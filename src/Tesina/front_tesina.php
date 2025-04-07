<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARsene Luciano</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="accessibility-buttons">
        <button id="theme-toggle" class="theme-btn">
            <i class="fas fa-moon"></i>
        </button>
        <button id="translate-btn" class="translate-btn">
            <i class="fas fa-globe"></i>
        </button>
    </div>

    <header>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">Chi sono</a></li>
                <li><a href="#projects">Progetti</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home" class="hero">
            <h1>ARsene Luciano</h1>
            <p>Benvenuto nel mio portfolio</p>
        </section>

        <section id="about" class="about">
            <h2>Chi sono</h2>
            <div class="about-content">
                <div class="about-image">
                    <img src="images/profile.jpg" alt="La mia foto">
                </div>
                <div class="about-text">
                    <p>Qui puoi inserire la tua descrizione personale</p>
                </div>
            </div>
        </section>

        <section id="projects" class="projects">
            <h2>Progetti</h2>
            <div class="project-grid">
                <!-- I tuoi progetti verranno inseriti qui -->
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 ARsene Luciano. Tutti i diritti riservati.</p>
    </footer>

    <script>
        // Tema scuro/chiaro
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const icon = themeToggle.querySelector('i');

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-theme');
            if (body.classList.contains('dark-theme')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        });

        // Traduzione (da implementare)
        document.getElementById('translate-btn').addEventListener('click', () => {
            // Implementa qui la logica di traduzione
        });
    </script>
</body>
</html>