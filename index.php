<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>John Chris Dacobor — PHP Web Developer</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Syne:wght@400;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #050508;
    --surface: #0d0d14;
    --card: #111118;
    --accent: #00f5a0;
    --accent2: #00d9f5;
    --accent3: #f500a0;
    --text: #e8e8f0;
    --muted: #5a5a72;
    --border: #1e1e2e;
    --glow: 0 0 40px rgba(0,245,160,0.15);
  }

  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  html { scroll-behavior: smooth; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Syne', sans-serif;
    overflow-x: hidden;
    cursor: none;
  }

  /* Custom Cursor */
  #cursor {
    width: 12px; height: 12px;
    background: var(--accent);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 9999;
    transition: transform 0.1s, opacity 0.3s;
    transform: translate(-50%, -50%);
  }
  #cursor-ring {
    width: 36px; height: 36px;
    border: 1.5px solid var(--accent);
    border-radius: 50%;
    position: fixed;
    pointer-events: none;
    z-index: 9998;
    transform: translate(-50%, -50%);
    transition: all 0.18s ease;
    opacity: 0.5;
  }
  body:hover #cursor { opacity: 1; }

  /* Canvas */
  #bg-canvas {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    z-index: 0;
    pointer-events: none;
  }

  /* Noise overlay */
  body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    pointer-events: none;
    z-index: 1;
    opacity: 0.4;
  }

  /* Layout */
  .wrapper { position: relative; z-index: 2; }

  /* NAV */
  nav {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 48px;
    backdrop-filter: blur(20px);
    background: rgba(5,5,8,0.7);
    border-bottom: 1px solid var(--border);
  }
  .nav-logo {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.6rem;
    letter-spacing: 0.12em;
    color: var(--accent);
    text-shadow: 0 0 20px rgba(0,245,160,0.4);
  }
  .nav-links { display: flex; gap: 32px; list-style: none; }
  .nav-links a {
    font-family: 'Space Mono', monospace;
    font-size: 0.72rem;
    color: var(--muted);
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    transition: color 0.3s;
    position: relative;
  }
  .nav-links a::after {
    content: '';
    position: absolute;
    bottom: -4px; left: 0;
    width: 0; height: 1px;
    background: var(--accent);
    transition: width 0.3s;
  }
  .nav-links a:hover { color: var(--accent); }
  .nav-links a:hover::after { width: 100%; }
  .nav-status {
    font-family: 'Space Mono', monospace;
    font-size: 0.68rem;
    color: var(--accent);
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .status-dot {
    width: 8px; height: 8px;
    background: var(--accent);
    border-radius: 50%;
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0%,100% { opacity: 1; box-shadow: 0 0 0 0 rgba(0,245,160,0.4); }
    50% { opacity: 0.7; box-shadow: 0 0 0 6px rgba(0,245,160,0); }
  }

  /* HERO */
  #hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 120px 48px 80px;
    position: relative;
  }
  .hero-content { max-width: 800px; }
  .hero-eyebrow {
    font-family: 'Space Mono', monospace;
    font-size: 0.72rem;
    color: var(--accent);
    letter-spacing: 0.25em;
    text-transform: uppercase;
    margin-bottom: 24px;
    opacity: 0;
    animation: fadeUp 0.8s 0.2s forwards;
  }
  .hero-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(4rem, 10vw, 9rem);
    line-height: 0.92;
    letter-spacing: 0.02em;
    margin-bottom: 28px;
    opacity: 0;
    animation: fadeUp 0.8s 0.4s forwards;
  }
  .hero-title .line-accent { color: var(--accent); display: block; }
  .hero-title .line-stroke {
    -webkit-text-stroke: 1px rgba(232,232,240,0.3);
    color: transparent;
    display: block;
  }
  .hero-desc {
    font-size: 1.05rem;
    color: var(--muted);
    line-height: 1.7;
    max-width: 480px;
    margin-bottom: 40px;
    opacity: 0;
    animation: fadeUp 0.8s 0.6s forwards;
  }
  .hero-desc span { color: var(--text); }
  .hero-cta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    opacity: 0;
    animation: fadeUp 0.8s 0.8s forwards;
  }
  .btn-primary {
    padding: 14px 32px;
    background: var(--accent);
    color: var(--bg);
    font-family: 'Space Mono', monospace;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    text-decoration: none;
    border: none;
    cursor: none;
    transition: all 0.3s;
    clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
  }
  .btn-primary:hover {
    background: var(--accent2);
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0,245,160,0.3);
  }
  .btn-outline {
    padding: 14px 32px;
    background: transparent;
    color: var(--text);
    font-family: 'Space Mono', monospace;
    font-size: 0.78rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    text-decoration: none;
    border: 1px solid var(--border);
    cursor: none;
    transition: all 0.3s;
    clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
  }
  .btn-outline:hover {
    border-color: var(--accent);
    color: var(--accent);
  }

  .hero-metrics {
    position: absolute;
    right: 48px;
    bottom: 80px;
    display: flex;
    flex-direction: column;
    gap: 24px;
    opacity: 0;
    animation: fadeLeft 0.8s 1s forwards;
  }
  .metric { text-align: right; }
  .metric-num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2.8rem;
    color: var(--accent);
    line-height: 1;
  }
  .metric-label {
    font-family: 'Space Mono', monospace;
    font-size: 0.62rem;
    color: var(--muted);
    letter-spacing: 0.15em;
    text-transform: uppercase;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  @keyframes fadeLeft {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
  }

  /* SECTION COMMON */
  section { padding: 100px 48px; }
  .section-label {
    font-family: 'Space Mono', monospace;
    font-size: 0.68rem;
    color: var(--accent);
    letter-spacing: 0.25em;
    text-transform: uppercase;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .section-label::before {
    content: '';
    width: 32px; height: 1px;
    background: var(--accent);
  }
  .section-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.4rem, 5vw, 4rem);
    line-height: 1;
    letter-spacing: 0.04em;
    margin-bottom: 60px;
  }

  /* SKILLS */
  #skills { background: var(--surface); }
  .skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2px;
  }
  .skill-card {
    background: var(--card);
    padding: 32px 28px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    transition: all 0.4s;
    cursor: none;
  }
  .skill-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,245,160,0.04) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.4s;
  }
  .skill-card:hover::before { opacity: 1; }
  .skill-card:hover { border-color: rgba(0,245,160,0.3); transform: translateY(-4px); }
  .skill-icon {
    font-size: 1.8rem;
    margin-bottom: 16px;
    display: block;
  }
  .skill-name {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 1.3rem;
    letter-spacing: 0.06em;
    margin-bottom: 8px;
  }
  .skill-level {
    height: 2px;
    background: var(--border);
    border-radius: 1px;
    overflow: hidden;
    margin-bottom: 8px;
  }
  .skill-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
    border-radius: 1px;
    width: 0;
    transition: width 1.2s ease;
  }
  .skill-pct {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    color: var(--muted);
  }

  /* PROJECTS */
  #projects { }
  .projects-tabs {
    display: flex;
    gap: 4px;
    margin-bottom: 48px;
    background: var(--surface);
    padding: 4px;
    border-radius: 2px;
    width: fit-content;
    border: 1px solid var(--border);
  }
  .tab-btn {
    font-family: 'Space Mono', monospace;
    font-size: 0.7rem;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 10px 24px;
    background: transparent;
    color: var(--muted);
    border: none;
    cursor: none;
    transition: all 0.3s;
    border-radius: 1px;
  }
  .tab-btn.active {
    background: var(--accent);
    color: var(--bg);
  }
  .tab-btn:not(.active):hover { color: var(--text); }

  .projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 2px;
  }
  .project-card {
    background: var(--card);
    border: 1px solid var(--border);
    padding: 36px 32px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    cursor: none;
    display: none;
  }
  .project-card.visible { display: block; }
  .project-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s;
  }
  .project-card:hover::after { transform: scaleX(1); }
  .project-card:hover {
    transform: translateY(-6px);
    border-color: rgba(0,245,160,0.2);
    box-shadow: 0 24px 60px rgba(0,0,0,0.4), var(--glow);
  }
  .project-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Space Mono', monospace;
    font-size: 0.6rem;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 5px 12px;
    border-radius: 1px;
    margin-bottom: 24px;
  }
  .project-status.active {
    background: rgba(0,245,160,0.1);
    color: var(--accent);
    border: 1px solid rgba(0,245,160,0.2);
  }
  .project-status.active::before {
    content: '';
    width: 6px; height: 6px;
    background: var(--accent);
    border-radius: 50%;
    animation: pulse 2s infinite;
  }
  .project-status.inactive {
    background: rgba(90,90,114,0.15);
    color: var(--muted);
    border: 1px solid var(--border);
  }
  .project-num {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 5rem;
    color: var(--border);
    position: absolute;
    right: 24px;
    top: 20px;
    line-height: 1;
    transition: color 0.4s;
  }
  .project-card:hover .project-num { color: rgba(0,245,160,0.08); }
  .project-name {
    font-family: 'Syne', sans-serif;
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 12px;
    line-height: 1.2;
  }
  .project-desc {
    font-size: 0.85rem;
    color: var(--muted);
    line-height: 1.65;
    margin-bottom: 28px;
  }
  .project-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 28px;
  }
  .tag {
    font-family: 'Space Mono', monospace;
    font-size: 0.6rem;
    padding: 4px 10px;
    background: rgba(255,255,255,0.04);
    color: var(--muted);
    border: 1px solid var(--border);
    letter-spacing: 0.08em;
  }
  .project-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Space Mono', monospace;
    font-size: 0.68rem;
    color: var(--accent);
    text-decoration: none;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    transition: gap 0.3s;
  }
  .project-link:hover { gap: 14px; }
  .project-link.disabled { color: var(--muted); cursor: not-allowed; }
  .project-link svg { width: 16px; height: 16px; }

  /* 3D Scene Section */
  #scene-section {
    padding: 0;
    height: 500px;
    position: relative;
    overflow: hidden;
    background: var(--surface);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
  }
  #scene-canvas {
    width: 100%;
    height: 100%;
    display: block;
  }
  .scene-overlay {
    position: absolute;
    top: 50%;
    left: 48px;
    transform: translateY(-50%);
    z-index: 10;
  }
  .scene-label {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2.5rem, 6vw, 5rem);
    line-height: 0.95;
    opacity: 0.9;
  }
  .scene-sub {
    font-family: 'Space Mono', monospace;
    font-size: 0.7rem;
    color: var(--muted);
    letter-spacing: 0.2em;
    text-transform: uppercase;
    margin-top: 12px;
  }

  /* ABOUT */
  #about {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: start;
  }
  .about-text p {
    font-size: 0.95rem;
    color: var(--muted);
    line-height: 1.8;
    margin-bottom: 16px;
  }
  .about-text p span { color: var(--text); }
  .about-side {}
  .info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
    font-size: 0.85rem;
  }
  .info-key {
    font-family: 'Space Mono', monospace;
    font-size: 0.65rem;
    color: var(--muted);
    letter-spacing: 0.1em;
    text-transform: uppercase;
  }
  .info-val { color: var(--accent); font-weight: 700; }

  /* CONTACT */
  #contact {
    background: var(--surface);
    text-align: center;
  }
  .contact-email {
    font-family: 'Bebas Neue', sans-serif;
    font-size: clamp(2rem, 6vw, 5.5rem);
    letter-spacing: 0.04em;
    color: var(--text);
    text-decoration: none;
    display: block;
    margin-bottom: 48px;
    transition: color 0.3s;
    position: relative;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
  }
  .contact-email::before {
    content: attr(data-text);
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, var(--accent), var(--accent2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    opacity: 0;
    transition: opacity 0.3s;
  }
  .contact-email:hover::before { opacity: 1; }

  .social-row {
    display: flex;
    justify-content: center;
    gap: 24px;
    flex-wrap: wrap;
  }
  .social-link {
    font-family: 'Space Mono', monospace;
    font-size: 0.7rem;
    color: var(--muted);
    text-decoration: none;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    transition: color 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .social-link:hover { color: var(--accent); }

  /* FOOTER */
  footer {
    padding: 24px 48px;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .footer-copy {
    font-family: 'Space Mono', monospace;
    font-size: 0.62rem;
    color: var(--muted);
    letter-spacing: 0.1em;
  }
  .footer-built {
    font-family: 'Space Mono', monospace;
    font-size: 0.62rem;
    color: var(--muted);
    letter-spacing: 0.08em;
  }
  .footer-built span { color: var(--accent); }

  /* Scroll indicator */
  .scroll-line {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    opacity: 0;
    animation: fadeUp 0.8s 1.2s forwards;
  }
  .scroll-text {
    font-family: 'Space Mono', monospace;
    font-size: 0.58rem;
    color: var(--muted);
    letter-spacing: 0.2em;
    text-transform: uppercase;
    writing-mode: vertical-rl;
  }
  .scroll-bar {
    width: 1px;
    height: 60px;
    background: var(--border);
    position: relative;
    overflow: hidden;
  }
  .scroll-bar::after {
    content: '';
    position: absolute;
    top: -100%;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--accent);
    animation: scrollDown 2s infinite;
  }
  @keyframes scrollDown {
    0% { top: -100%; }
    100% { top: 200%; }
  }

  /* Intersection observer fade */
  .reveal {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.7s ease, transform 0.7s ease;
  }
  .reveal.revealed { opacity: 1; transform: none; }

  @media (max-width: 768px) {
    nav { padding: 16px 24px; }
    .nav-links { display: none; }
    section { padding: 80px 24px; }
    #hero { padding: 100px 24px 80px; }
    .hero-metrics { display: none; }
    #about { grid-template-columns: 1fr; gap: 40px; }
    .projects-grid { grid-template-columns: 1fr; }
    footer { flex-direction: column; gap: 8px; text-align: center; }
    .scene-overlay { left: 24px; }
  }
</style>
</head>
<body>

<div id="cursor"></div>
<div id="cursor-ring"></div>
<canvas id="bg-canvas"></canvas>

<div class="wrapper">

  <!-- NAV -->
  <nav>
    <div class="nav-logo">JCD.DEV</div>
    <ul class="nav-links">
      <li><a href="#skills">Skills</a></li>
      <li><a href="#projects">Projects</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
    <div class="nav-status">
      <span class="status-dot"></span>
      Available for Work
    </div>
  </nav>

  <!-- HERO -->
  <section id="hero">
    <div class="hero-content">
     
      <h1 class="hero-title">
        <span class="line-accent">Building</span>
        <span>Digital</span>
        <span class="line-stroke">Experiences.</span>
      </h1>
      <p class="hero-desc">
        I craft <span>scalable web systems</span> — from dental clinic management to real estate platforms — using PHP, MySQL, and modern frontend technologies.
      </p>
      <div class="hero-cta">
        <a href="#projects" class="btn-primary">View Projects</a>
        <a href="#contact" class="btn-outline">Get In Touch</a>
      </div>
    </div>

    <div class="hero-metrics">
      <div class="metric">
        <div class="metric-num">5+</div>
        <div class="metric-label">Years Coding</div>
      </div>
      <div class="metric">
        <div class="metric-num">7+</div>
        <div class="metric-label">Projects Built</div>
      </div>
      <div class="metric">
        <div class="metric-num">3</div>
        <div class="metric-label">Live Sites</div>
      </div>
    </div>

    <div class="scroll-line">
      <span class="scroll-bar"></span>
      <span class="scroll-text">Scroll</span>
    </div>
  </section>

  <!-- 3D SCENE -->
  <div id="scene-section">
    <canvas id="scene-canvas"></canvas>
    <div class="scene-overlay">
      <div class="scene-label">FULL<br>STACK<br>PHP</div>
      <div class="scene-sub">// Drag to rotate</div>
    </div>
  </div>

  <!-- SKILLS -->
  <section id="skills">
    <p class="section-label">Tech Stack</p>
    <h2 class="section-title">What I Work With</h2>
    <div class="skills-grid" id="skillsGrid">
      <!-- Filled by JS -->
    </div>
  </section>

  <!-- PROJECTS -->
  <section id="projects">
    <p class="section-label">Portfolio</p>
    <h2 class="section-title">Selected Work</h2>
    <div class="projects-tabs">
      <button class="tab-btn active" data-filter="all">All</button>
      <button class="tab-btn" data-filter="active">Live ↗</button>
      <button class="tab-btn" data-filter="inactive">Archived</button>
    </div>
    <div class="projects-grid" id="projectsGrid">
      <!-- Filled by JS -->
    </div>
  </section>

  <!-- ABOUT -->
  <section id="about">
    <div class="about-text">
      <p class="section-label">About Me</p>
      <h2 class="section-title" style="margin-bottom:32px;">John Chris<br>Dacobor</h2>
      <p>I'm <span>John Chris Dacobor</span>, a PHP full-stack web developer from <span>Cagayan de Oro, Philippines</span> with over <span>5 years of hands-on experience</span> building real-world digital systems from the ground up.</p>
      <p>My journey into web development started with a simple curiosity — <span>how do websites actually work?</span> That question never stopped. I graduated from <span>IBA College of Mindanao</span>, where I honed my technical foundations and developed a deep appreciation for software that solves genuine human problems.</p>
      <p>Over the years I've grown from building school projects into <span>delivering fully functional management systems</span> — dental clinics, hardware stores, libraries — and maintaining <span>three live production websites</span> for real clients. Every project taught me something new about architecture, user experience, and the craft of writing clean, maintainable code.</p>
      <p>What drives me is the moment a client sees their workflow <span>completely transformed by software I built</span>. Whether it's a librarian tracking thousands of books digitally for the first time, or a store owner having real-time inventory at their fingertips — that impact is what I build for.</p>
      <p>Outside of code, I'm someone who <span>constantly experiments and learns</span> — always exploring new tools, frameworks, and ideas to bring better solutions to every project I take on.</p>
    </div>
    <div class="about-side">
      <div class="info-row"><span class="info-key">Full Name</span><span class="info-val">John Chris Dacobor</span></div>
      <div class="info-row"><span class="info-key">Location</span><span class="info-val">Cagayan de Oro, PH</span></div>
      <div class="info-row"><span class="info-key">Education</span><span class="info-val">IBA College of Mindanao</span></div>
      <div class="info-row"><span class="info-key">Experience</span><span class="info-val">5+ Years</span></div>
      <div class="info-row"><span class="info-key">Primary Stack</span><span class="info-val">PHP + MySQL</span></div>
      <div class="info-row"><span class="info-key">Frontend</span><span class="info-val">HTML / CSS / JS</span></div>
      <div class="info-row"><span class="info-key">Speciality</span><span class="info-val">Management Systems</span></div>
      <div class="info-row"><span class="info-key">Active Sites</span><span class="info-val">3 Live Domains</span></div>
      <div class="info-row"><span class="info-key">Status</span><span class="info-val" style="color:var(--accent)">Open to Projects ✦</span></div>
    </div>
  </section>

  <!-- CONTACT -->
  <section id="contact">
    <p class="section-label" style="justify-content:center;">Contact</p>
    <h2 class="section-title" style="text-align:center;">Let's Build<br>Something.</h2>
    <a href="mailto:Johndacobor@gmail.com" class="contact-email" data-text="Johndacobor@gmail.com">Johndacobor@gmail.com</a>
    <div class="social-row">
      <a href="#" class="social-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
        GitHub
      </a>
      <a href="https://zenovapvi.com" target="_blank" class="social-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        Zenova PVI
      </a>
      <a href="https://hdm-res.com" target="_blank" class="social-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
        HDM Res
      </a>
    </div>
  </section>

  <footer>
    <div class="footer-copy">© 2025 John Chris Dacobor — Cagayan de Oro, PH</div>
    <div class="footer-built">Built with <span>PHP + HTML + CSS + JS</span></div>
  </footer>

</div>

<script>
// ===== CURSOR =====
const cursor = document.getElementById('cursor');
const cursorRing = document.getElementById('cursor-ring');
let mx = 0, my = 0, rx = 0, ry = 0;
document.addEventListener('mousemove', e => {
  mx = e.clientX; my = e.clientY;
  cursor.style.left = mx + 'px';
  cursor.style.top = my + 'px';
});
function animRing() {
  rx += (mx - rx) * 0.12;
  ry += (my - ry) *.12;
  cursorRing.style.left = rx + 'px';
  cursorRing.style.top = ry + 'px';
  requestAnimationFrame(animRing);
}
animRing();
document.querySelectorAll('a,button,.skill-card,.project-card').forEach(el => {
  el.addEventListener('mouseenter', () => { cursorRing.style.transform = 'translate(-50%,-50%) scale(2)'; cursorRing.style.borderColor = 'var(--accent)'; });
  el.addEventListener('mouseleave', () => { cursorRing.style.transform = 'translate(-50%,-50%) scale(1)'; cursorRing.style.borderColor = 'var(--accent)'; });
});

// ===== BACKGROUND PARTICLE CANVAS =====
(function() {
  const canvas = document.getElementById('bg-canvas');
  const ctx = canvas.getContext('2d');
  let W, H, particles = [], mouse = {x: -999, y: -999};

  function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
  resize();
  window.addEventListener('resize', resize);
  document.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; });

  for (let i = 0; i < 80; i++) {
    particles.push({
      x: Math.random() * window.innerWidth,
      y: Math.random() * window.innerHeight,
      vx: (Math.random() - 0.5) * 0.3,
      vy: (Math.random() - 0.5) * 0.3,
      r: Math.random() * 1.5 + 0.5,
      alpha: Math.random() * 0.4 + 0.1
    });
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);
    particles.forEach(p => {
      p.x += p.vx; p.y += p.vy;
      if (p.x < 0) p.x = W; if (p.x > W) p.x = 0;
      if (p.y < 0) p.y = H; if (p.y > H) p.y = 0;
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(0,245,160,${p.alpha})`;
      ctx.fill();
    });
    // Connect nearby
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx*dx + dy*dy);
        if (dist < 100) {
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.strokeStyle = `rgba(0,245,160,${0.08 * (1 - dist/100)})`;
          ctx.lineWidth = 0.5;
          ctx.stroke();
        }
      }
    }
    requestAnimationFrame(draw);
  }
  draw();
})();

// ===== 3D SCENE CANVAS =====
(function() {
  const canvas = document.getElementById('scene-canvas');
  const ctx = canvas.getContext('2d');
  let W, H;
  function resize() { W = canvas.width = canvas.offsetWidth; H = canvas.height = canvas.offsetHeight; }
  resize();
  window.addEventListener('resize', resize);

  // 3D cube vertices
  const verts = [
    [-1,-1,-1],[1,-1,-1],[1,1,-1],[-1,1,-1],
    [-1,-1,1],[1,-1,1],[1,1,1],[-1,1,1]
  ];
  const edges = [
    [0,1],[1,2],[2,3],[3,0],[4,5],[5,6],[6,7],[7,4],
    [0,4],[1,5],[2,6],[3,7]
  ];
  const faces = [[0,1,2,3],[4,5,6,7],[0,1,5,4],[2,3,7,6],[1,2,6,5],[0,3,7,4]];

  let rotX = 0.3, rotY = 0.3;
  let targetX = 0.3, targetY = 0.3;
  let isDragging = false, lastMX = 0, lastMY = 0;
  let time = 0;

  canvas.addEventListener('mousedown', e => { isDragging = true; lastMX = e.clientX; lastMY = e.clientY; });
  window.addEventListener('mouseup', () => isDragging = false);
  window.addEventListener('mousemove', e => {
    if (!isDragging) return;
    const dx = e.clientX - lastMX;
    const dy = e.clientY - lastMY;
    targetY += dx * 0.008;
    targetX += dy * 0.008;
    lastMX = e.clientX; lastMY = e.clientY;
  });

  canvas.addEventListener('touchstart', e => { isDragging = true; lastMX = e.touches[0].clientX; lastMY = e.touches[0].clientY; });
  canvas.addEventListener('touchend', () => isDragging = false);
  canvas.addEventListener('touchmove', e => {
    if (!isDragging) return;
    const dx = e.touches[0].clientX - lastMX;
    const dy = e.touches[0].clientY - lastMY;
    targetY += dx * 0.008;
    targetX += dy * 0.008;
    lastMX = e.touches[0].clientX; lastMY = e.touches[0].clientY;
  });

  function rotateVert(v) {
    let [x, y, z] = v;
    // rotate X
    let y2 = y * Math.cos(rotX) - z * Math.sin(rotX);
    let z2 = y * Math.sin(rotX) + z * Math.cos(rotX);
    y = y2; z = z2;
    // rotate Y
    let x2 = x * Math.cos(rotY) + z * Math.sin(rotY);
    let z3 = -x * Math.sin(rotY) + z * Math.cos(rotY);
    return [x2, y, z3];
  }

  function project(v) {
    const fov = 4;
    const z = v[2] + fov;
    const scale = Math.min(W, H) * 0.18;
    return [
      W/2 + (v[0] / z) * fov * scale,
      H/2 + (v[1] / z) * fov * scale,
      v[2]
    ];
  }

  // Extra floating cubes
  const miniCubes = [];
  for (let i = 0; i < 5; i++) {
    miniCubes.push({
      x: (Math.random() - 0.5) * W * 0.8,
      y: (Math.random() - 0.5) * H * 0.6,
      rotX: Math.random() * Math.PI * 2,
      rotY: Math.random() * Math.PI * 2,
      speed: 0.004 + Math.random() * 0.008,
      size: 0.2 + Math.random() * 0.25,
      floatOffset: Math.random() * Math.PI * 2
    });
  }

  function drawMiniCube(mc, t) {
    const cx = W/2 + mc.x + Math.sin(t * 0.4 + mc.floatOffset) * 20;
    const cy = H/2 + mc.y + Math.cos(t * 0.3 + mc.floatOffset) * 15;
    const rx = mc.rotX + t * mc.speed;
    const ry = mc.rotY + t * mc.speed * 1.3;
    const scale = Math.min(W, H) * mc.size * 0.08;

    const rotated = verts.map(v => {
      let [x, y, z] = v;
      let y2 = y*Math.cos(rx) - z*Math.sin(rx), z2 = y*Math.sin(rx)+z*Math.cos(rx); y=y2;z=z2;
      let x2 = x*Math.cos(ry)+z*Math.sin(ry), z3 = -x*Math.sin(ry)+z*Math.cos(ry);
      return [x2, y, z3];
    });
    const proj = rotated.map(v => [cx + v[0]*scale, cy + v[1]*scale]);

    edges.forEach(([a,b]) => {
      ctx.beginPath();
      ctx.moveTo(proj[a][0], proj[a][1]);
      ctx.lineTo(proj[b][0], proj[b][1]);
      ctx.strokeStyle = 'rgba(0,245,160,0.12)';
      ctx.lineWidth = 0.8;
      ctx.stroke();
    });
  }

  function draw() {
    time++;
    if (!isDragging) {
      targetY += 0.004;
    }
    rotX += (targetX - rotX) * 0.05;
    rotY += (targetY - rotY) * 0.05;

    ctx.clearRect(0, 0, W, H);

    // Draw mini cubes first
    miniCubes.forEach(mc => drawMiniCube(mc, time * 0.016));

    // Grid background lines
    ctx.strokeStyle = 'rgba(30,30,46,0.6)';
    ctx.lineWidth = 1;
    const step = 60;
    for (let x = 0; x < W; x += step) {
      ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, H); ctx.stroke();
    }
    for (let y = 0; y < H; y += step) {
      ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(W, y); ctx.stroke();
    }

    // Main cube
    const rotated = verts.map(rotateVert);
    const projected = rotated.map(project);

    // Draw faces with transparency
    const faceColors = [
      'rgba(0,245,160,0.04)', 'rgba(0,217,245,0.04)',
      'rgba(0,245,160,0.03)', 'rgba(0,217,245,0.03)',
      'rgba(245,0,160,0.03)', 'rgba(0,245,160,0.05)'
    ];
    faces.forEach((face, fi) => {
      const avgZ = face.reduce((s, vi) => s + rotated[vi][2], 0) / 4;
      ctx.beginPath();
      ctx.moveTo(projected[face[0]][0], projected[face[0]][1]);
      face.forEach(vi => ctx.lineTo(projected[vi][0], projected[vi][1]));
      ctx.closePath();
      ctx.fillStyle = faceColors[fi];
      ctx.fill();
    });

    // Draw edges
    edges.forEach(([a, b]) => {
      const az = rotated[a][2], bz = rotated[b][2];
      const alpha = 0.3 + (az + bz + 2) * 0.08;
      ctx.beginPath();
      ctx.moveTo(projected[a][0], projected[a][1]);
      ctx.lineTo(projected[b][0], projected[b][1]);
      ctx.strokeStyle = `rgba(0,245,160,${Math.min(alpha, 0.7)})`;
      ctx.lineWidth = 1.5;
      ctx.stroke();
    });

    // Glow vertices
    projected.forEach(([x, y]) => {
      ctx.beginPath();
      ctx.arc(x, y, 3, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(0,245,160,0.8)';
      ctx.fill();
      // outer glow
      const g = ctx.createRadialGradient(x, y, 0, x, y, 12);
      g.addColorStop(0, 'rgba(0,245,160,0.25)');
      g.addColorStop(1, 'rgba(0,245,160,0)');
      ctx.beginPath();
      ctx.arc(x, y, 12, 0, Math.PI * 2);
      ctx.fillStyle = g;
      ctx.fill();
    });

    // Scanning line
    const scanY = (Math.sin(time * 0.015) * 0.5 + 0.5) * H;
    const scanGrad = ctx.createLinearGradient(0, scanY - 40, 0, scanY + 40);
    scanGrad.addColorStop(0, 'rgba(0,245,160,0)');
    scanGrad.addColorStop(0.5, 'rgba(0,245,160,0.06)');
    scanGrad.addColorStop(1, 'rgba(0,245,160,0)');
    ctx.fillStyle = scanGrad;
    ctx.fillRect(0, scanY - 40, W, 80);

    requestAnimationFrame(draw);
  }
  draw();
})();

// ===== SKILLS DATA =====
const skills = [
  { icon: '🐘', name: 'PHP', level: 90 },
  { icon: '🗄️', name: 'MySQL', level: 88 },
  { icon: '🌐', name: 'HTML/CSS', level: 92 },
  { icon: '⚡', name: 'JavaScript', level: 78 },
  { icon: '🅱️', name: 'Bootstrap', level: 85 },
  { icon: '🔧', name: 'Laravel', level: 70 },
  { icon: '📊', name: 'RESTful APIs', level: 75 },
  { icon: '🐙', name: 'Git/GitHub', level: 80 },
];

const grid = document.getElementById('skillsGrid');
skills.forEach(s => {
  grid.innerHTML += `
    <div class="skill-card reveal">
      <span class="skill-icon">${s.icon}</span>
      <div class="skill-name">${s.name}</div>
      <div class="skill-level"><div class="skill-fill" data-level="${s.level}"></div></div>
      <div class="skill-pct">${s.level}% proficiency</div>
    </div>`;
});

// ===== PROJECTS DATA =====
const projects = [
  {
    type: 'active',
    name: 'Zenova PVI',
    desc: 'A live professional website delivering digital solutions and services. Custom-built with PHP for performance and maintainability.',
    tags: ['PHP', 'MySQL', 'HTML/CSS', 'JS'],
    url: 'https://zenovapvi.com',
    num: '01'
  },
  {
    type: 'active',
    name: 'HDM Resources',
    desc: 'A live resource and service platform. Full-stack PHP implementation with dynamic content management.',
    tags: ['PHP', 'MySQL', 'Bootstrap', 'JS'],
    url: 'https://hdm-res.com',
    num: '02'
  },
  {
    type: 'active',
    name: 'Reel Place',
    desc: 'An active media/content platform hosted at caps-hub.com. Built to handle user-generated content and media.',
    tags: ['PHP', 'MySQL', 'CSS3', 'JS'],
    url: 'https://reel-place.caps-hub.com',
    num: '03'
  },
  {
    type: 'inactive',
    name: 'Dental Clinic Management System',
    desc: 'Comprehensive clinic management solution — patient records, appointment scheduling, billing, and treatment history tracking.',
    tags: ['PHP', 'MySQL', 'Bootstrap', 'CRUD'],
    url: null,
    num: '04'
  },
  {
    type: 'inactive',
    name: 'Hardware POS & Inventory System',
    desc: 'Point-of-sale system tailored for hardware stores — real-time inventory tracking, transaction history, and sales reporting.',
    tags: ['PHP', 'MySQL', 'JS', 'POS'],
    url: null,
    num: '05'
  },
  {
    type: 'inactive',
    name: 'Library Management System',
    desc: 'Digital library system for cataloging, book borrowing, return tracking, member management, and overdue alerts.',
    tags: ['PHP', 'MySQL', 'Bootstrap', 'CRUD'],
    url: null,
    num: '06'
  },
  {
    type: 'inactive',
    name: 'Real Estate Landing Page',
    desc: 'Informational landing page for real estate listings — property cards, inquiry forms, map integration, and responsive design.',
    tags: ['PHP', 'HTML/CSS', 'JS', 'Responsive'],
    url: null,
    num: '07'
  }
];

const pgrid = document.getElementById('projectsGrid');
projects.forEach(p => {
  pgrid.innerHTML += `
    <div class="project-card visible reveal" data-type="${p.type}">
      <div class="project-num">${p.num}</div>
      <div class="project-status ${p.type}">${p.type === 'active' ? 'Live' : 'Archived'}</div>
      <div class="project-name">${p.name}</div>
      <div class="project-desc">${p.desc}</div>
      <div class="project-tags">${p.tags.map(t => `<span class="tag">${t}</span>`).join('')}</div>
      ${p.url
        ? `<a href="${p.url}" target="_blank" class="project-link">Visit Site <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17L17 7M17 7H7M17 7v10"/></svg></a>`
        : `<span class="project-link disabled">Source Not Public <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg></span>`
      }
    </div>`;
});

// ===== TABS =====
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    const filter = this.dataset.filter;
    document.querySelectorAll('.project-card').forEach(card => {
      if (filter === 'all' || card.dataset.type === filter) {
        card.classList.add('visible');
      } else {
        card.classList.remove('visible');
      }
    });
  });
});

// ===== INTERSECTION OBSERVER =====
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('revealed');
      // Animate skill bars
      entry.target.querySelectorAll && entry.target.querySelectorAll('.skill-fill').forEach(bar => {
        bar.style.width = bar.dataset.level + '%';
      });
    }
  });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
document.querySelectorAll('.skill-card').forEach(el => observer.observe(el));

// ===== SKILL BARS GLOBAL =====
const skillObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.querySelectorAll('.skill-fill').forEach(bar => {
        bar.style.width = bar.dataset.level + '%';
      });
    }
  });
}, { threshold: 0.3 });
document.querySelectorAll('.skill-card').forEach(el => skillObserver.observe(el));

// Section reveals
document.querySelectorAll('section, .project-card, .skill-card').forEach(el => {
  if (!el.classList.contains('reveal')) el.classList.add('reveal');
  observer.observe(el);
});
</script>
</body>
</html>