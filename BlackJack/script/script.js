'use strict';

const suits = ['spade', 'heart', 'diamond', 'clover'];
const values = ['A','2','3','4','5','6','7','8','9','10','J','Q','K'];

let deck = [];
let player = [];
let dealer = [];
let gameOver = false;
let dealerHidden = true;
let coins = 100;
let currentBet = 10;
let BlackjackWin = false;
let Restarting = false;
let Hitting = false;

function createDeck() {
  deck = [];
  for (let suit of suits) {
    for (let value of values) {
      deck.push({ suit, value });
    }
  }
  for (let i = deck.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [deck[i], deck[j]] = [deck[j], deck[i]];
  }
}

function drawCard() {
  if (deck.length === 0) {
    console.warn('デッキが空です。新しいデッキを生成します。');
    createDeck(); 
  }
  return deck.pop();
}

async function dealInitialCards() {
  player = [];
  dealer = [];
  gameOver = false;
  dealerHidden = true;
  BlackjackWin = false;
  showMessage('');
  updateUI();

  player.push(drawCard()); updateUI(); await delay(300);
  dealer.push(drawCard()); updateUI(); await delay(300);
  player.push(drawCard()); updateUI(); await delay(300);
  dealer.push(drawCard()); updateUI();

  checkBlackjack();
  toggleButtons(true);
}

function renderCards(containerId, hand) {
  const container = document.getElementById(containerId);
  container.innerHTML = '';
  hand.forEach((card, i) => {
    const div = document.createElement('div');
    div.className = 'card';

    if (containerId === 'dealer-cards' && dealerHidden && i === 1) {
      div.classList.add('back');
      div.textContent = '';
    } else {
      const inner = document.createElement('div');
      inner.className = 'card-content';

      const valueText = document.createElement('div');
      valueText.className = 'card-value';
      valueText.textContent = card.value;
      valueText.style.color = (card.suit === 'heart' || card.suit === 'diamond') ? 'red' : 'black';

      const suitTopLeft = document.createElement('img');
      suitTopLeft.className = 'card-suit-top-left';
      suitTopLeft.src = `images/${card.suit}.png`;

      const suitBottomRight = document.createElement('img');
      suitBottomRight.className = 'card-suit-bottom-right';
      suitBottomRight.src = `images/${card.suit}.png`;

      inner.appendChild(valueText);
      inner.appendChild(suitTopLeft);
      inner.appendChild(suitBottomRight);
      div.appendChild(inner);
    }

    div.style.animationDelay = `${i * 0.1}s`;
    container.appendChild(div);
  });
}

function getPoints(hand) {
  let total = 0, aces = 0;
  for (let card of hand) {
    if (['J', 'Q', 'K'].includes(card.value)) total += 10;
    else if (card.value === 'A') { total += 11; aces++; }
    else total += parseInt(card.value);
  }
  while (total > 21 && aces > 0) { total -= 10; aces--; }
  return total;
}

function updateUI() {
  renderCards('player-cards', player);
  renderCards('dealer-cards', dealer);
  document.getElementById('player-score').textContent = `合計: ${getPoints(player)}`;
  document.getElementById('dealer-score').textContent = dealerHidden ? '合計: ???' : `合計: ${getPoints(dealer)}`;
}

function updateCoinDisplay() {
  document.getElementById('coinBalance').textContent = coins;
}

function showMessage(msg, type = '') {
  const el = document.getElementById('message');
  el.innerHTML = msg;
  el.className = '';
  if (type) el.classList.add(type);
}

async function hit() {
  if (gameOver || Hitting || player.length < 2) return;
  Hitting = true;

  player.push(drawCard());
  updateUI();
  await delay(400);

  toggleButtons(true);

  if (getPoints(player) > 21) {
    endGame('バースト！<br>あなたの負けです。', 'lose');
  }

  Hitting = false;
}

async function stand() {
  if (gameOver || player.length < 2) return;
  toggleButtons(false);
  await delay(500);
  dealerHidden = false;
  updateUI();
  await dealerTurn();
}

async function dealerTurn() {
  while (getPoints(dealer) < 17) {
    await delay(600);
    dealer.push(drawCard());
    updateUI();
  }
  const p = getPoints(player), d = getPoints(dealer);
  if (d > 21) endGame('ディーラーがバースト！<br>あなたの勝ち！', 'win');
  else if (p > d) endGame('あなたの勝ち！', 'win');
  else if (p < d) endGame('あなたの負け！', 'lose');
  else endGame('引き分け！<br>ベット額を返還します。', 'draw');
}

function endGame(msg, result) {
  gameOver = true;
  toggleButtons(false);

  if (result === 'win' && BlackjackWin) {
    coins += Math.floor(currentBet * 2.5);
  } else if (result === 'win') {
    coins += currentBet * 2;
  } else if (result === 'draw') {
    coins += currentBet;
  }

  updateCoinDisplay();
  showMessage(msg, result);
  updateUI();
  
  document.getElementById('betBtn').disabled = false;
  document.getElementById('bet').disabled = false;
}

function restart() {
  if (Restarting) return;
  Restarting = true;

  const betBtn = document.getElementById('betBtn');
  const betInput = document.getElementById('bet');

  betBtn.disabled = true;
  betInput.disabled = true;

  currentBet = parseInt(betInput.value);
  if (isNaN(currentBet) || currentBet <= 0 || currentBet > coins) {
    alert('正しいベット金額（1 〜 ' + coins + ' coin）を入力してください');
    Restarting = false;
    betBtn.disabled = false;
    betInput.disabled = false;
    betInput.focus();
    return;
  }

  coins -= currentBet;
  updateCoinDisplay();
  createDeck();

  dealInitialCards().then(() => {
    Restarting = false;
  });
}

async function doubleDown() {
  if (gameOver || player.length !== 2 || coins < currentBet) return;
  coins -= currentBet;
  currentBet *= 2;
  updateCoinDisplay();

  player.push(drawCard());
  updateUI();
  await delay(400);

  if (getPoints(player) > 21) {
    endGame('バースト！あなたの負けです。', 'lose');
  } else {
    await stand();
  }
}

function checkBlackjack() {
  const p = getPoints(player), d = getPoints(dealer);
  if (p === 21 && d === 21) {
    dealerHidden = false;
    endGame('お互いブラックジャック！引き分け！ベット額は戻りました。', 'draw');
  } else if (p === 21) {
    dealerHidden = false;
    BlackjackWin = true;
    endGame('ブラックジャック！あなたの勝ち！', 'win');
  } else if (d === 21) {
    dealerHidden = false;
    endGame('ディーラーがブラックジャック！あなたの負け！', 'lose');
  }
}

function delay(ms) {
  return new Promise(res => setTimeout(res, ms));
}

function toggleButtons(enabled) {
  document.getElementById('hitBtn').disabled = !enabled;
  document.getElementById('standBtn').disabled = !enabled;
  const doubleBtn = document.getElementById('doubleBtn');
  doubleBtn.disabled = !enabled || player.length !== 2 || coins < currentBet;
}

window.addEventListener('keydown', (e) => {
  const betInput = document.getElementById('bet');
  const activeTag = document.activeElement.tagName.toLowerCase();
  if (activeTag === 'input' || activeTag === 'textarea') return;

  const step = (e.key === 'ArrowRight') ? 10 :
                (e.key === 'ArrowLeft') ? -10 :
                (e.key === 'ArrowUp') ? 1 :
                (e.key === 'ArrowDown') ? -1 : 0;

  if (step !== 0 && !gameOver && !Restarting) {
    e.preventDefault();
    let val = parseInt(betInput.value) || 0;
    val += step;
    val = Math.max(1, Math.min(val, coins));
    betInput.value = val;
    return;
  }

  switch (e.key) {
    case 'Tab':
      e.preventDefault();
      if (!document.getElementById('standBtn').disabled) stand();
      break;
    case 'Shift':
      if (e.location === 1) {
        e.preventDefault();
        if (!document.getElementById('hitBtn').disabled) hit();
      }
      break;
    case ' ':
    case 'Spacebar':
      e.preventDefault();
      const betBtn = document.getElementById('betBtn');
      if (!betBtn.disabled) betBtn.click();
      break;
    case 'Enter':
      const doubleBtn = document.getElementById('doubleBtn');
      if (!doubleBtn.disabled) {
        e.preventDefault();
        doubleDown();
      }
      break;
  }
});

updateCoinDisplay();