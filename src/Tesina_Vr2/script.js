// Assicurati che GSAP e ScrollTrigger siano importati o inclusi nel tuo progetto
gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {
  // Imposta lo smooth scroll con Lenis
  const lenis = new Lenis();
  lenis.on("scroll", ScrollTrigger.update);
  gsap.ticker.add((time) => {
    lenis.raf(time * 1000);
  });
  gsap.ticker.lagSmoothing(0);

  // Seleziona tutti gli elementi necessari dal DOM
  const heroImgContainer = document.querySelector(".hero-img-container");
  const heroImgLogo = document.querySelector(".hero-img-logo");
  const heroImgCopy = document.querySelector(".hero-img-copy");
  const fadeOverlay = document.querySelector(".fade-overlay");
  const svgOverlay = document.querySelector(".overlay");
  const overlayCopy = document.querySelector(".overlay-copy h1"); // Seleziona l'h1 specifico

  // Impostazioni iniziali
  const initialOverlayScale = 1150;

  // Setup della maschera SVG con i dati del logo
  const logoContainer = document.querySelector(".logo-container");
  const logoMask = document.getElementById("logoMask");
  
  // Assicurati che 'logoData' sia disponibile (es. importato da logo.js)
  logoMask.setAttribute("d", logoData);

  // Calcola le dimensioni e le posizioni per allineare la maschera
  const logoDimensions = logoContainer.getBoundingClientRect();
  const logoBoundingBox = logoMask.getBBox();
  const horizontalScaleRatio = logoDimensions.width / logoBoundingBox.width;
  const verticalScaleRatio = logoDimensions.height / logoBoundingBox.height;
  const logoScaleFactor = Math.min(horizontalScaleRatio, verticalScaleRatio);
  const logoHorizontalPosition = logoDimensions.left + (logoDimensions.width - logoBoundingBox.width * logoScaleFactor) / 2 - logoBoundingBox.x * logoScaleFactor;
  const logoVerticalPosition = logoDimensions.top + (logoDimensions.height - logoBoundingBox.height * logoScaleFactor) / 2 - logoBoundingBox.y * logoScaleFactor;
  
  logoMask.setAttribute( "transform", `translate(${logoHorizontalPosition}, ${logoVerticalPosition}) scale(${logoScaleFactor})`);

  // Crea l'animazione con ScrollTrigger
  ScrollTrigger.create({
    trigger: ".hero",
    start: "top top",
    end: `${window.innerHeight * 5}px`,
    pin: true,
    pinSpacing: true,
    scrub: 1,
    onUpdate: (self) => {
      const scrollProgress = self.progress;

      // --- BLOCCO 1: Dissolvenza degli elementi iniziali ---
      // Questa parte gestisce la scomparsa del logo iniziale e del testo "Scroll down"
      if (scrollProgress <= 0.15) {
        const fadeOpacity = 1 - scrollProgress * (1 / 0.15);
        gsap.set([heroImgLogo, heroImgCopy], { opacity: fadeOpacity });
      } else {
        gsap.set([heroImgLogo, heroImgCopy], { opacity: 0 });
      }

      // --- BLOCCO 2: Animazione di scaling principale ---
      // Questa parte gestisce lo zoom-out dell'immagine di sfondo e lo zoom-in della maschera SVG
      if (scrollProgress <= 0.85) {
        const normalizedProgress = scrollProgress * (1 / 0.85);
        const heroImgContainerScale = 1.5 - 0.5 * normalizedProgress;
        const overlayScale = initialOverlayScale * Math.pow(1 / initialOverlayScale, normalizedProgress);
        
        gsap.set(heroImgContainer, { scale: heroImgContainerScale });
        gsap.set(svgOverlay, { scale: overlayScale });
      }
      
      // --- BLOCCO 3: Dissolvenza dell'overlay bianco ---
      if (scrollProgress >= 0.25) {
        const fadeOverlayOpacity = Math.min(1, (scrollProgress - 0.25) * (1 / 0.4));
        gsap.set(fadeOverlay, { opacity: fadeOverlayOpacity });
      }

      // --- BLOCCO 4: Rivelazione del testo finale con gradiente ---
      if (scrollProgress > 0.6 && scrollProgress <= 0.85) {
        // Normalizza il progresso per l'intervallo 0.6 -> 0.85
        const overlayCopyRevealProgress = (scrollProgress - 0.6) * (1 / 0.25);
        const gradientSpread = 100;
        const gradientBottomPosition = 240 - overlayCopyRevealProgress * 280;
        const gradientTopPosition = gradientBottomPosition - gradientSpread;
        const overlayCopyScale = 1.25 - 0.25 * overlayCopyRevealProgress;

        gsap.set(overlayCopy, {
          opacity: overlayCopyRevealProgress,
          scale:  overlayCopyScale,
        
          // GRADIENTE: modifica solo background-image, non shorthand “background”
          backgroundImage: `linear-gradient(to bottom,
            #111117 0%,
            #111117 ${gradientTopPosition}%,
            #e66461 ${gradientBottomPosition}%,
            #e66461 100%)`,
        
          // Assicuriamo inline anche i ritagli e la trasparenza
          backgroundClip:       "text",
          webkitBackgroundClip: "text",
          mozBackgroundClip:    "text",
        
          webkitTextFillColor:  "transparent",
          mozTextFillColor:     "transparent"
        });
        
      } else if (scrollProgress <= 0.6) {
        // Nasconde il testo prima che inizi la sua animazione
        gsap.set(overlayCopy, { opacity: 0 });
      }
    },
  });
});