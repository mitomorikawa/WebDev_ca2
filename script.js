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
      cardArray = [[ "emoji/skin/green.png","emoji/eyes/closed.png", "emoji/mouth/open.png"],
                   ["emoji/skin/red.png","emoji/eyes/laughing.png", "emoji/mouth/sad.png"] , 
                   ["emoji/skin/yellow.png","emoji/eyes/long.png", "emoji/mouth/smiling.png"]];
   } else {
      // gametype: medium, complex
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

function startSimpleGame () {
   let cardArray = generateCards(2, 3, true);
   let gameGrid = document.querySelector(".game_grid");
   gameGrid.innerHTML = "";
   for (let i = 0; i < 6; i++) {
      let card = document.createElement("div");
      card.classList.add("card");
      for (let j = 0; j < 3; j++) {
         let cardImg = document.createElement("img");
         cardImg.src = cardArray[i][j];
         card.appendChild(cardImg);
      }

      gameGrid.appendChild(card);
   }
   gameGrid.style.gridTemplateColumns = "repeat(3, auto)";
   gameGrid.style.gridTemplateRows = "repeat(2, auto)";
   gameGrid.style.gridAutoColumns = "100%"; 


}