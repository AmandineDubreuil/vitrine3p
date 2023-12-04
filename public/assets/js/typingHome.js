const dynamicText = document.querySelector("h2 span");

//mettre 1 ou 2 mots maxi, pas très long
const words = [
  " acréditées PSSM ",
  " spécialistes SST ",
];

let wordIndex = 0;
let charIndex = 0;
let isDeleting = false;

const typeEffect = () => {
  const currentWord = words[wordIndex];
  const currentChar = currentWord.substring(0, charIndex);
  dynamicText.textContent = currentChar;
  dynamicText.classList.add("stop-blinking");

  if (!isDeleting && charIndex < currentWord.length) {
    charIndex++;
    // Si la condition est vraie, écris le caractère suivant
    setTimeout(typeEffect, 200);
  } else if (isDeleting && charIndex > 0) {
    //Si la condition est vraie, retire le caractère précédant
    charIndex--;
    setTimeout(typeEffect, 100);
  } else {
    isDeleting = !isDeleting;
    dynamicText.classList.remove("stop-blinking");
    // passe au mot suivant
    wordIndex = !isDeleting ? (wordIndex + 1) % words.length : wordIndex;
    setTimeout(typeEffect, 1200);
  }
};

typeEffect();
