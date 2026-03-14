function setSimple() {
   document.querySelector("#mediumPhotoGenerator").style.display = "none"; // if the simple avatar mode is selected, dont show the image selectors for the other avatar modes
   document.querySelector("#complexPhotoGenerator").style.display = "none";
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.removeAttribute("required")); // And dont make the radio buttons for the other avatar modes required
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

function setMedium() {
   document.querySelector("#mediumPhotoGenerator").style.display = "block"; // if the medium avatar mode is selected, only show the image selector for the medium avatar modes
   document.querySelector("#complexPhotoGenerator").style.display = "none";
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.setAttribute("required", "")); // And only make the radio buttons for the medium avatar modes required
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

function setComplex() {
   document.querySelector("#complexPhotoGenerator").style.display = "block";// if the complex avatar mode is selected, only show the image selector for the complex avatar modes
   document.querySelector("#mediumPhotoGenerator").style.display = "none";
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.setAttribute("required", "")); // And only make the radio buttons for the complex avatar modes required
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

function startGame() {
   const selectedType = document.querySelector('input[name="type"]:checked');
   if (!selectedType) { // If the game type isnt selected, throw an alert
      alert("Please select a game type!");
      return;
   }
   document.querySelector(".start_screen").style.display = "none"; // The start button and the radio buttons for selecting a game type should disappear
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

function generateCards(matchSize, setCount, preset) {
   // matchSize: number of matching cards in a set
   // pairs: number of sets of matching cards
   // preset: boolean. If true, use preset images. If false, generate random images using emoji.
   let cardArray = [];
   if (preset) {
      // if the gametype is simple
      cardArray = [["emoji/skin/green.png", "emoji/eyes/closed.png", "emoji/mouth/open.png", 0],
      ["emoji/skin/red.png", "emoji/eyes/laughing.png", "emoji/mouth/sad.png", 1],
      ["emoji/skin/yellow.png", "emoji/eyes/long.png", "emoji/mouth/smiling.png", 2]];
   } else {
      // if the gametype is medium or complex
      let indices = [] // numbers to generate indices of component photos
      while (indices.length < setCount) {
         let index = Math.floor(Math.random() * 108); // Generate a random number between 0 and 107
         if (!indices.includes(index)) { // the indices should be unique
            indices.push(index);
         }
      }

      const skin = ["green", "red", "yellow"];
      const eyes = ["closed", "laughing", "long", "normal", "rolling", "winking"];
      const mouth = ["open", "sad", "smiling", "straight", "surprise", "teeth"];
      for (let i = 0; i < setCount; i++) { 
         // Decode the random index back into specific feature indices:
         // skinIndex picks 1 of 3, eyesIndex picks 1 of 6, mouthIndex picks 1 of 6.
         let skinIndex = Math.floor(indices[i] / 36); 
         let eyesIndex = Math.floor((indices[i] % 36) / 6);
         let mouthIndex = indices[i] % 6;
         cardArray.push(["emoji/skin/" + skin[skinIndex] + ".png", "emoji/eyes/" + eyes[eyesIndex] + ".png", "emoji/mouth/" + mouth[mouthIndex] + ".png", i]); // pushes an array of 3 image file names and the index i, which works as an identifier to distinguish between different images
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
   gameGrid.innerHTML = ""; // Refresh gamegrid
   for (let i = 0; i < matchSize * setCount; i++) { // Populate gamegrid with cards
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
         cardFrontImg.src = cardArray[i][j]; // Take a card image from cardArray
         cardFront.appendChild(cardFrontImg);
      }
      gameGrid.appendChild(card);

   }
   gameGrid.style.gridTemplateColumns = `repeat(${setCount}, auto)`;
   gameGrid.style.gridTemplateRows = `repeat(${matchSize}, auto)`;
   gameGrid.style.gridAutoColumns = "100%";
}

function delay(time) { //delay the execution of the next line
   return new Promise(resolve => setTimeout(resolve, time));
}

let complexSettings = [[2, 5], [2, 6], [3, 5], [3, 6], [4, 5], [4, 6]]; // Card configurations of the levels in the complex game. 
// In each array, the first element denotes the number of cards to match, and the second element denotes the number of matches

// A gameStatus object has the following attributes:
// card_status: an array of (matchSize * setCount) strings. Each string is either "back"(face down), "front"(face up but unmatched) or "matched" (face up and matched)
// front: the number of "front" cards
// match: the number of "matched" cards 
// attempts: the number of attempts made
//time: elapsed time 
// score(): the method to calculate the score


async function flipCard(cards, gameStatus, i, cardArray, matchSize, setCount, startTime, timer) { // this function is called every time a card is clicked
   const scoreDisplay = document.querySelector(".score");
   const attemptsDisplay = document.querySelector(".attempts");
   const scoreInput = document.querySelector("#score_input");
   const typeInput = document.querySelector("#type_input");
   const levelInput = document.querySelector("#level_input");
   if (gameStatus.front === 0) { // if no cards are face up except the matching ones
      if (gameStatus.card_status[i] === "back") { // if you click on a face down card
         gameStatus.card_status[i] = "front"; // mark it as face up
         gameStatus.front++; // increment the number of the unmatched face-up cards
         cards[i].classList.toggle("flip"); // flip the card
      }
   } else { // if there are unmatched face-up cards in the grid
      if (gameStatus.card_status[i] === "back") { // if you click on a face down card
         let frontCardIndex = gameStatus.card_status.indexOf("front"); // the index of an unmatched face-up cards in the grid
         let frontCardIndex2 = frontCardIndex !== -1
            ? gameStatus.card_status.indexOf("front", frontCardIndex + 1)
            : -1; // the index of another unmatched face-up card in the grid, if any
         let frontCardIndex3 = frontCardIndex2 !== -1
            ? gameStatus.card_status.indexOf("front", frontCardIndex2 + 1)
            : -1; // the index of yet another unmatched face-up card in the grid, if any

         if ( // if all the face up cards that haven't been marked as "matched" are the same
            cardArray[frontCardIndex][3] === cardArray[i][3] &&
            (matchSize < 3 || (frontCardIndex2 !== -1 && cardArray[frontCardIndex2][3] === cardArray[i][3])) &&
            (matchSize < 4 || (frontCardIndex3 !== -1 && cardArray[frontCardIndex3][3] === cardArray[i][3]))
         ) {
            // mark them as "matched"
            gameStatus.card_status[i] = "matched"; 
            gameStatus.card_status[frontCardIndex] = "matched";
            if (matchSize >= 3) {
               gameStatus.card_status[frontCardIndex2] = "matched";
            }
            if (matchSize >= 4) {
               gameStatus.card_status[frontCardIndex3] = "matched";
            }
            gameStatus.front = 0; // update the count of unmatched face-up cards to 0
            gameStatus.attempts++; // increment the count of attempts
            gameStatus.match++; // increment the number of matched pairs
            attemptsDisplay.innerHTML = "<p>Attempts: " + gameStatus.attempts + "</p>"; // Update the html line for the count of attempts
            cards[i].classList.toggle("flip"); // flip the card
            if (gameStatus.match === setCount) { // If all the cards have been matched
               if (startTime) { // If the timer is set (medium & complex)
                  let now = new Date().getTime(); 
                  gameStatus.time = (now - startTime) / 1000 / 60; 
                  if (timer) {
                     clearInterval(timer); // stop the timer
                  }
               }
               scoreDisplay.innerHTML = "<p>Score: " + gameStatus.score().toFixed(2) + " </p>";// Update the html line for score
               typeInput.value = document.querySelector('input[name="type"]:checked').value; // Pass the game type to the "end_game" div, so that it can be stored in results.json
               document.querySelector(".game_description").innerHTML = ""; // Remove the game description line
               
               document.querySelector(".end_game").style.display = "flex"; // Display the end_game div
               document.querySelector(".end_game a").style.display = "flex"; // Display "Play again"
               document.querySelector(".end_game input").style.display = "flex"; // Display the submit button
               
               if (document.querySelector('input[name="type"]:checked').value === "complex") { // if the game type is complex
                  document.querySelector(`#level${complexLevel + 1}_cell`).innerHTML = gameStatus.score().toFixed(2); // Display the score in complex_table
                  scores.push(parseFloat(gameStatus.score().toFixed(2))); // Store the score in the scores array
                  if (parseFloat(gameStatus.score().toFixed(2)) > parseFloat(complexBestScore[complexLevel + 1])) { //if a new high score is achieved
                     document.querySelector(".game_screen").style.backgroundColor = "#FFD700"; // change the background colour to gold
                  }
                  scoreInput.value = scores.join(","); // Pass the scores to the "end_game" div, so that it can be stored in results.json
                  levelInput.value = complexLevel + 1; // Pass the level to the "end_game" div, so that it can be stored in results.json
                  document.querySelector(".complex_table").style.display = "flex"; // DIsplay complex_table

                  if (complexLevel === 5) { // If you finished the highest level (complexLevel is 0 indexed)
                     document.querySelector("#total_cell").innerHTML = scores.reduce((a, b) => a + b, 0).toFixed(2); // show the total score of the complex game
                  } else { // If the level of the complex game is below 6
                     document.querySelector(".end_game button").style.display = "flex"; // show the "Next level" button
                  }

                  complexLevel++; // Increment the level
               } else {// if the game type is simple or medium
                  scoreInput.value = gameStatus.score().toFixed(2); // Pass the scores to the "end_game" div, so that it can be stored in results.json
                  levelInput.value = 0; // Set the level to 0 
               }
            } else if (gameStatus.attempts >= (matchSize + 1) * setCount) {// If the user makes too many attempts
               if (timer) {
                  clearInterval(timer);// Stop the timer
               }
               document.querySelector(".game_description").innerHTML = ""; //Remove the game description
               document.querySelector(".end_game").style.display = "flex"; // Display the end_game div
               document.querySelector(".end_game a").style.display = "flex";// Display "Play again"
               document.querySelector(".end_game p").style.display = "flex";// Display the "Too many attempts" line
               document.querySelector("#submit").style.display = "none";// Dont display the submit button
               document.querySelector(".end_game button").style.display = "none"; //Dont display "Next Level" button
            }
         } else if ( // if the card matches the face-up cards but the number of "front" cards are smaller than matchSize
            cardArray[frontCardIndex][3] === cardArray[i][3] &&
            gameStatus.front < matchSize - 1
         ) {
            gameStatus.card_status[i] = "front"; // mark it as face up
            gameStatus.front++; // increment the number of the unmatched face-up cards
            cards[i].classList.toggle("flip"); //flip it
         } else { // If the card doesnt match one of the "front" cards
            gameStatus.card_status[i] = "back"; // mark it as face down
            // Mark all the "front" cards as face down
            gameStatus.card_status[frontCardIndex] = "back";
            if (frontCardIndex2 !== -1) {
               gameStatus.card_status[frontCardIndex2] = "back";
            }
            if (frontCardIndex3 !== -1) {
               gameStatus.card_status[frontCardIndex3] = "back";
            }
            gameStatus.front = 0; // Update the count of unmatched face-up cards to 0
            gameStatus.attempts++; // increment the count of attempts
            attemptsDisplay.innerHTML = "<p>Attempts: " + gameStatus.attempts + "</p>";// Update the html line for the count of attempts
            cards[i].classList.toggle("flip"); // flip the card
            await delay(1000); // wait for 1 second
            cards[i].classList.toggle("flip"); // flip back the card
            // Flip back all the "front" cards
            cards[frontCardIndex].classList.toggle("flip"); 
            if (frontCardIndex2 !== -1) {
               cards[frontCardIndex2].classList.toggle("flip");
            }
            if (frontCardIndex3 !== -1) {
               cards[frontCardIndex3].classList.toggle("flip");
            }
            if (gameStatus.attempts >= (matchSize + 1) * setCount) { // If the user makes too many attempts
               if (timer) {
                  clearInterval(timer); // Stop the timer
               }
               document.querySelector(".game_description").innerHTML = ""; //Remove the game description
               document.querySelector(".end_game").style.display = "flex";  // Display the end_game div
               document.querySelector(".end_game a").style.display = "flex"; // Display "Play again"
               document.querySelector(".end_game p").style.display = "flex";// Display the "Too many attempts" line
               document.querySelector("#submit").style.display = "none";// Dont display the submit button
               document.querySelector(".end_game button").style.display = "none";//Dont display "Next Level" button
            }
         }
      }
   }
}

function startSimpleGame() {
   const matchSize = 2;
   const setCount = 3;
   let cardArray = generateCards(matchSize, setCount, true);// generate preset shuffled cards
   displayCards(cardArray, matchSize, setCount);
   document.querySelector(".game_status").style.display = "block"; // Display the game status
   document.querySelector(".game_description").innerHTML = `<p>Match ${matchSize} cards</p>`; // Display the game description


   const gameStatus = {
      card_status: ["back", "back", "back", "back", "back", "back"], 
      front: 0,
      match: 0,
      attempts: 0,
      time: 0,
      score() {
         return (100 - (this.attempts - setCount) / (matchSize * setCount) * 100) * Math.pow(0.5, this.time);
      }
   }

   const attemptsDisplay = document.querySelector(".attempts");
   attemptsDisplay.innerHTML = "<p>Attempts: 0 </p>"; // Display the number of attempts


   const cards = document.querySelectorAll(".card");
   for (let i = 0; i < matchSize * setCount; i++) {
      cards[i].addEventListener("click", function () {
         flipCard(cards, gameStatus, i, cardArray, 2, 3, 0, 0); // Attach click listener to each card to trigger the flip logic
      });
   }




}

function startMediumGame() {
   let startTime = new Date().getTime();
   const matchSize = 2;
   const setCount = 5;
   let cardArray = generateCards(matchSize, setCount, false); // Combine image components and generate shuffled cards
   displayCards(cardArray, matchSize, setCount);
   document.querySelector(".game_status").style.display = "block";// Display the game status
   document.querySelector(".game_description").innerHTML = `<p>Match ${matchSize} cards</p>`; // Display the game description

   const gameStatus = {
      card_status: [],
      front: 0,
      match: 0,
      attempts: 0,
      time: 0,
      score() {
         return (100 - (this.attempts - setCount) / (matchSize * setCount) * 100) * Math.pow(0.5, this.time);
      }
   }

   for (let i = 0; i < matchSize * setCount; i++) {
      gameStatus.card_status.push("back");
   }

   const attemptsDisplay = document.querySelector(".attempts");
   attemptsDisplay.innerHTML = "<p>Attempts: 0 </p>";// Display the number of attempts
   const timeDisplay = document.querySelector(".time");
   timeDisplay.innerHTML = "<p>Time: 0m 0s </p>";// Display the elapsed time
   const timer = setInterval(function () { // Build and display a timer
      let now = new Date().getTime();
      let elapsedTime = Math.floor((now - startTime) / 1000);
      let seconds = elapsedTime % 60;
      let minutes = Math.floor(elapsedTime / 60);
      timeDisplay.innerHTML = "<p>Time: " + minutes + "m " + seconds + "s </p>";
   }, 1000);


   const cards = document.querySelectorAll(".card"); 
   for (let i = 0; i < matchSize * setCount; i++) {
      cards[i].addEventListener("click", function () {
         flipCard(cards, gameStatus, i, cardArray, matchSize, setCount, startTime, timer);// Attach click listener to each card to trigger the flip logic
      });
   }
}

function ComplexGameLevel(matchSize, setCount, level) {

   let startTime = new Date().getTime();
   [matchSize, setCount] = complexSettings[level - 1]
   let cardArray = generateCards(matchSize, setCount, false);// Combine image components and generate shuffled cards
   displayCards(cardArray, matchSize, setCount);
   document.querySelector(".game_status").style.display = "block";// Display the game status
   document.querySelector(".game_description").innerHTML = `<p>Match ${matchSize} cards</p>`; // Display the game description


   const gameStatus = {
      card_status: [],
      front: 0,
      match: 0,
      attempts: 0,
      time: 0,
      score() {
         return (100 - (this.attempts - setCount) / (matchSize * setCount) * 100) * Math.pow(0.5, this.time);
      }
   }

   for (let i = 0; i < matchSize * setCount; i++) {
      gameStatus.card_status.push("back");
   }
   const levelDisplay = document.querySelector(".level");
   levelDisplay.innerHTML = "<p>Level: " + level + "</p>";// Display the level
   const scoreDisplay = document.querySelector(".score");
   scoreDisplay.innerHTML = "<p>Score: </p>";// Display the score
   const attemptsDisplay = document.querySelector(".attempts");
   attemptsDisplay.innerHTML = "<p>Attempts: 0 </p>";// Display the number of attempts
   const timeDisplay = document.querySelector(".time");
   timeDisplay.innerHTML = "<p>Time: 0m 0s </p>";// Display the elapsed time
   const timer = setInterval(function () { // Build and display a timer
      let now = new Date().getTime();
      let elapsedTime = Math.floor((now - startTime) / 1000);
      let seconds = elapsedTime % 60;
      let minutes = Math.floor(elapsedTime / 60);
      timeDisplay.innerHTML = "<p>Time: " + minutes + "m " + seconds + "s </p>";
   }, 1000);


   const cards = document.querySelectorAll(".card");
   for (let i = 0; i < matchSize * setCount; i++) {
      cards[i].addEventListener("click", function () {
         flipCard(cards, gameStatus, i, cardArray, matchSize, setCount, startTime, timer);// Attach click listener to each card to trigger the flip logic
      });
   }
}

//This function is called when the user clicks on "Start the Game"
function startComplexGame() {
   complexLevel = 0;
   scores = [];
   runComplexLevel();
}

// This function initialises the game screen and executes the game by calling ComplexGameLevel. Called by startComplexGame() and the "Next Level" button
function runComplexLevel() {
   if (complexLevel >= complexSettings.length) { // If all the levels are played, stop the game
      return;
   }
   document.querySelector(".game_screen").style.backgroundColor = "gray"; // Set the background colour to gray
   document.querySelector(".end_game").style.display = "none"; // Hide end_game
   document.querySelector(".end_game a").style.display = "none";
   document.querySelector(".end_game p").style.display = "none";
   document.querySelector(".end_game button").style.display = "none";

   const [matchSize, setCount] = complexSettings[complexLevel];

   ComplexGameLevel(matchSize, setCount, complexLevel + 1);

}