let words  = [
    { text: "Mobilier", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Éclairage", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Couleurs", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Texture", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Disposition", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Inspiration", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Fonctionnalité", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Harmonie", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Élégance", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Innovation", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Modularité", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Élégance", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Harmonie", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Transition", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Perspective", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Circulation", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Intimité", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Flexibilité", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Minimalisme", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Technologie", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Durabilité", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Authenticité", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Originalité", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Artisanat", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Esthétique", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Culture", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Tradition", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Modernité", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Open space", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Cloisonnement", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Détente", size: Math.floor(Math.random() * 70) + 10 },
    { text: "collaboration", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Acoustique", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Innovation", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Accessibilité", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Décoration", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Transformabilité", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Multifonctionnalité", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Durabilité", size: Math.floor(Math.random() * 70) + 10 },
    { text: "Utilisateur", size: Math.floor(Math.random() * 60) + 10 },
    { text: "Expérience", size: Math.floor(Math.random() * 70) + 10 },
];
const container = document.getElementById('wordCloud');

words.forEach(wrds => {
    const span = document.createElement('span');
    span.innerText = wrds.text;
    span.style.fontSize = `${wrds.size}px`;
    container.appendChild(span)
})