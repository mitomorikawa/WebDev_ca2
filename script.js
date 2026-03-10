function setSimple() {
   document.querySelector("#mediumPhotoGenerator").style.display = "none";
   document.querySelector("#complexPhotoGenerator").style.display = "none";
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.removeAttribute("required"));
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

function setMedium () {
   document.querySelector("#mediumPhotoGenerator").style.display = "block";
   document.querySelector("#complexPhotoGenerator").style.display = "none";
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.setAttribute("required", ""));
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

function setComplex () {
   document.querySelector("#complexPhotoGenerator").style.display = "block";
   document.querySelector("#mediumPhotoGenerator").style.display = "none";
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.setAttribute("required", ""));
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

function startGame () {
   document.querySelector(".start_screen").style.display = "none";
   const selectedType = document.querySelector('input[name="type"]:checked');
   if (selectedType) {
      if (selectedType.value === "simple") {
         startSimpleGame();
      } else if (selectedType.value === "medium") {
         startMediumGame();
      } else if (selectedType.value === "complex") {
         startComplexGame();
      }
   }
}

// function to shuffle an array (ref: https://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array)
function shuffle(array) {
   let currentIndex = array.length;
 
   // While there remain elements to shuffle...
   while (currentIndex != 0) {
 
     // Pick a remaining element...
     let randomIndex = Math.floor(Math.random() * currentIndex);
     currentIndex--;
 
     // And swap it with the current element.
     [array[currentIndex], array[randomIndex]] = [
       array[randomIndex], array[currentIndex]];
   }
   return array;
 }

function generateCards(matchSize, setCount, preset){
   // matchSize: number of matching cards in a set
   // pairs: number of sets of matching cards
   // preset: boolean. If true, use preset images. If false, generate random images using emoji.
   let cardArray = [];
   if (preset) {
      // gametype: simple
      cardArray = [[ "emoji/skin/green.png","emoji/eyes/closed.png", "emoji/mouth/open.png", 0],
                   ["emoji/skin/red.png","emoji/eyes/laughing.png", "emoji/mouth/sad.png", 1] , 
                   ["emoji/skin/yellow.png","emoji/eyes/long.png", "emoji/mouth/smiling.png", 2]];
   } else {
      // gametype: medium, complex
      let indices = [] // numbers to generater indices of component photos
      while (indices.length < setCount) {
         let index = Math.floor(Math.random() * 108);
         if (!indices.includes(index)) {
            indices.push(index);
         }
      }

      const skin = ["green", "red", "yellow"];
      const eyes = ["closed", "laughing", "long", "normal", "rolling", "winking"];
      const mouth = ["open", "sad", "smiling", "straight", "surprise", "teeth"];
      for (let i = 0; i < setCount; i++) {
         let skinIndex = Math.floor(indices[i] / 36);
         let eyesIndex = Math.floor((indices[i] % 36) / 6);
         let mouthIndex = indices[i] % 6;
         cardArray.push(["emoji/skin/" + skin[skinIndex] + ".png", "emoji/eyes/" + eyes[eyesIndex]+ ".png", "emoji/mouth/" + mouth[mouthIndex]+ ".png", i]);
      }
   }

   let finalCardArray = [];
   // duplicate
   for (let i = 0; i < matchSize; i++) {
      finalCardArray = finalCardArray.concat(cardArray);
   }

   // shuffle
   finalCardArray = shuffle(finalCardArray);
   return finalCardArray;
}

// Function to display flippable cards (ref: https://dev.to/mugas/flip-cards-with-javascript-2ad0)
function displayCards(cardArray, matchSize, setCount) {
   let gameGrid = document.querySelector(".game_grid");
   gameGrid.innerHTML = "";
   for (let i = 0; i < matchSize*setCount; i++) {
      let card = document.createElement("div");
      card.classList.add("card");
      let cardFront = document.createElement("div");
      cardFront.classList.add("card_front");
      card.appendChild(cardFront);
      let cardBack = document.createElement("div");
      cardBack.classList.add("card_back");
      card.appendChild(cardBack);
      for (let j = 0; j < 3; j++) {
         let cardFrontImg = document.createElement("input");
         cardFrontImg.type = "image";
         cardFrontImg.src = cardArray[i][j];
         cardFront.appendChild(cardFrontImg);
      }
      gameGrid.appendChild(card);

   }
   gameGrid.style.gridTemplateColumns = `repeat(${setCount}, auto)`;
   gameGrid.style.gridTemplateRows = `repeat(${matchSize}, auto)`;
   gameGrid.style.gridAutoColumns = "100%"; 
}

function delay(time) {
   return new Promise(resolve => setTimeout(resolve, time));
 }

/* 
card states: back, front, matched

1. click on a card when all the other cards arent flipped
3. two same cards
4. two different cards
5. click on a flipped card
*/
let complexSettings = [[2,5],[2,6], [3,5], [3,6], [4,5], [4,6]];


async function flipCard(cards, gameStatus, i, cardArray, matchSize, setCount, startTime, timer) {
   console.log("Card clicked:", cardArray[i][3]);
   const scoreDisplay = document.querySelector(".score");
   const attemptsDisplay = document.querySelector(".attempts");
   if (gameStatus.front === 0) {
      if (gameStatus.card_status[i] === "back") {
         gameStatus.card_status[i] = "front";
         gameStatus.front++;
         cards[i].classList.toggle("flip");
      } 
   } else {
      if (gameStatus.card_status[i] === "back") {
         let frontCardIndex = gameStatus.card_status.indexOf("front");
         let frontCardIndex2 = frontCardIndex !== -1
         ? gameStatus.card_status.indexOf("front", frontCardIndex + 1)
         : -1;
         let frontCardIndex3 = frontCardIndex2 !== -1 
         ? gameStatus.card_status.indexOf("front", frontCardIndex2 + 1)
         : -1;

         if (
            cardArray[frontCardIndex][3] === cardArray[i][3] &&
            (matchSize < 3 || (frontCardIndex2 !== -1 && cardArray[frontCardIndex2][3] === cardArray[i][3])) &&
            (matchSize < 4 || (frontCardIndex3 !== -1 && cardArray[frontCardIndex3][3] === cardArray[i][3]))
         ) {
            gameStatus.card_status[i] = "matched";
            gameStatus.card_status[frontCardIndex] = "matched";
            if (matchSize >= 3) {
               gameStatus.card_status[frontCardIndex2] = "matched";
            }
            if (matchSize >= 4) {
               gameStatus.card_status[frontCardIndex3] = "matched";
            }
            gameStatus.front = 0;
            gameStatus.attempts++;
            gameStatus.match++;
            attemptsDisplay.innerHTML = "<p>Attempts: " + gameStatus.attempts + "</p>";
            cards[i].classList.toggle("flip");
            if (gameStatus.match === setCount) {
               if (startTime) {
                  let now = new Date().getTime();
                  gameStatus.time = (now - startTime) / 1000 / 60;if (timer) {
                     clearInterval(timer);
                  }
               }
               scoreDisplay.innerHTML = "<p>Score: " + gameStatus.score().toFixed(2) + " </p>";
               if (timer) {
                  clearInterval(timer);
               }
               document.querySelector(".end_game").style.display = "flex";
               document.querySelector(".end_game a").style.display = "flex";
               document.querySelector(".end_game input").style.display = "flex";
               if (document.querySelector('input[name="type"]:checked').value==="complex" && complexLevel < 5) {
                  document.querySelector(".end_game button").style.display = "flex";
                  scores.push(gameStatus.score());
                  console.log(complexLevel);
                  complexLevel++;
               } else if (document.querySelector('input[name="type"]:checked').value==="complex" && complexLevel === 5) {
                  scores.push(gameStatus.score());
                  console.log("All scores:", scores);
               }
               return gameStatus.score();
            }
         } else if (
            cardArray[frontCardIndex][3] === cardArray[i][3] &&
            gameStatus.front < matchSize - 1
         ) {
            gameStatus.card_status[i] = "front";
            gameStatus.front++;
            cards[i].classList.toggle("flip");
         } else {
            gameStatus.card_status[i] = "back";
            gameStatus.card_status[frontCardIndex] = "back";
            if (frontCardIndex2 !== -1) {
                  gameStatus.card_status[frontCardIndex2] = "back";
               }
            if (frontCardIndex3 !== -1) {
                  gameStatus.card_status[frontCardIndex3] = "back";
               }
            gameStatus.front = 0;
            gameStatus.attempts++;
            attemptsDisplay.innerHTML = "<p>Attempts: " + gameStatus.attempts + "</p>";
            cards[i].classList.toggle("flip");
            await delay(1000);
            cards[i].classList.toggle("flip");
            cards[frontCardIndex].classList.toggle("flip");
            if (frontCardIndex2 !== -1) {
               cards[frontCardIndex2].classList.toggle("flip");
            }
            if (frontCardIndex3 !== -1) {
               cards[frontCardIndex3].classList.toggle("flip");
            }
            if (gameStatus.attempts === (matchSize + 1) * setCount) {
               if (timer) {
                  clearInterval(timer);
               }
               document.querySelector(".end_game").style.display = "flex";
               document.querySelector(".end_game a").style.display = "flex";
               document.querySelector(".end_game p").style.display = "flex";
            }
         }
      }
   }
   console.log(gameStatus.card_status);
}



function startSimpleGame () {
   const matchSize = 2;
   const setCount = 3;
   let cardArray = generateCards(matchSize, setCount, true);
   displayCards(cardArray, matchSize, setCount); 
   document.querySelector(".game_status").style.display = "block";

   
   const gameStatus = {
      card_status: ["back","back","back","back","back","back"],
      front: 0,
      match: 0,
      attempts: 0,
      time: 0,
      score() {
         return (100 - (this.attempts - setCount) / (matchSize*setCount) * 100) * Math.pow(0.5, this.time);
      } 
   }

   const attemptsDisplay = document.querySelector(".attempts");
   attemptsDisplay.innerHTML = "<p>Attempts: 0 </p>";


   const cards = document.querySelectorAll(".card");
   for (let i = 0; i < matchSize*setCount; i++){
      cards[i].addEventListener("click", function() {
         flipCard(cards, gameStatus, i, cardArray, 2, 3, 0, 0);
      });
   }


   

}

function startMediumGame () {
   let startTime = new Date().getTime();
   const matchSize = 2;
   const setCount = 5;
   let cardArray = generateCards(matchSize, setCount, false);
   displayCards(cardArray, matchSize, setCount); 
   document.querySelector(".game_status").style.display = "block";

   
   const gameStatus = {
      card_status: [],
      front: 0,
      match: 0,
      attempts: 0,
      time: 0,
      score() {
         return (100 - (this.attempts - setCount) / (matchSize*setCount) * 100) * Math.pow(0.5, this.time);
      } 
   }

   for (let i = 0; i < matchSize*setCount; i++){
      gameStatus.card_status.push("back");
   }

   const attemptsDisplay = document.querySelector(".attempts");
   attemptsDisplay.innerHTML = "<p>Attempts: 0 </p>";
   const timeDisplay = document.querySelector(".time");
   timeDisplay.innerHTML = "<p>Time: 0m 0s </p>";
   const timer = setInterval(function() {
      let now = new Date().getTime();
      let elapsedTime = Math.floor((now - startTime) / 1000);
      let seconds = elapsedTime % 60;
      let minutes = Math.floor(elapsedTime / 60);
      timeDisplay.innerHTML = "<p>Time: " + minutes + "m " + seconds + "s </p>";
   }, 1000);


   const cards = document.querySelectorAll(".card");
   for (let i = 0; i < matchSize*setCount; i++){
      cards[i].addEventListener("click", function() {
         flipCard(cards, gameStatus, i, cardArray, matchSize, setCount, startTime, timer);
      });
   }
}

function ComplexGameLevel(matchSize,setCount, level) {

   let startTime = new Date().getTime();
   [matchSize,setCount] = complexSettings[level - 1]
   let cardArray = generateCards(matchSize, setCount, false);
   displayCards(cardArray, matchSize, setCount); 
   document.querySelector(".game_status").style.display = "block";

      
   const gameStatus = {
      card_status: [],
      front: 0,
      match: 0,
      attempts: 0,
      time: 0,
      score() {
         return (100 - (this.attempts - setCount) / (matchSize*setCount) * 100) * Math.pow(0.5, this.time);
      } 
   }

   for (let i = 0; i < matchSize*setCount; i++){
      gameStatus.card_status.push("back");
   }

   const attemptsDisplay = document.querySelector(".attempts");
   attemptsDisplay.innerHTML = "<p>Attempts: 0 </p>";
   const timeDisplay = document.querySelector(".time");
   timeDisplay.innerHTML = "<p>Time: 0m 0s </p>";
   const timer = setInterval(function() {
      let now = new Date().getTime();
      let elapsedTime = Math.floor((now - startTime) / 1000);
      let seconds = elapsedTime % 60;
      let minutes = Math.floor(elapsedTime / 60);
      timeDisplay.innerHTML = "<p>Time: " + minutes + "m " + seconds + "s </p>";
   }, 1000);


   const cards = document.querySelectorAll(".card");
   for (let i = 0; i < matchSize*setCount; i++){
      cards[i].addEventListener("click", function() {
         flipCard(cards, gameStatus, i, cardArray, matchSize, setCount, startTime, timer);
      });
   }
}

function startComplexGame() {
   complexLevel = 0;
   scores = [];
   runComplexLevel();
}

function runComplexLevel() {
   if (complexLevel >= complexSettings.length) {
      console.log("All scores:", scores);
      return;
   }
   document.querySelector(".end_game").style.display = "none";
   document.querySelector(".end_game a").style.display = "none";
   document.querySelector(".end_game p").style.display = "none";
   document.querySelector(".end_game button").style.display = "none";
   
   const [matchSize, setCount] = complexSettings[complexLevel];

   ComplexGameLevel(matchSize, setCount, complexLevel + 1);

}