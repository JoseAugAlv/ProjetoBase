<footer>
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Logo e Sobre -->
            <div class="footer-col footer-about">
                <div class="footer-logo">
                    <h3><?= strtoupper(App::getName()) ?><span>.</span></h3>
                </div>
                <p>
                    Sistema de gestão de usuários e permissões.
                    Desenvolvido para ser adaptado a qualquer projeto.
                </p>
                <div class="footer-social">
                    <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Navegação -->
            <div class="footer-col">
                <h4>Navegação</h4>
                <ul>
                    <li><a href="<?= App::getBasePath() ?>/"><i class="fas fa-chevron-right"></i> Início</a></li>
                    <li><a href="<?= App::getBasePath() ?>/sobre"><i class="fas fa-chevron-right"></i> Sobre</a></li>
                    <li><a href="<?= App::getBasePath() ?>/termos"><i class="fas fa-chevron-right"></i> Termos</a></li>
                    <li><a href="<?= App::getBasePath() ?>/tutorial"><i class="fas fa-chevron-right"></i> Tutorial</a></li>
                </ul>
            </div>

            <!-- Contato -->
            <div class="footer-col">
                <h4>Contato</h4>
                <ul>
                    <li><a href="mailto:contato@josealvesdev.com"><i class="fas fa-envelope"></i> contato@josealvesdev.com</a></li>
                    <li><a href="https://www.instagram.com/jose.asx_" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i> @jose.asx_</a></li>
                    <li><a href="https://github.com/josealvesdev" target="_blank" rel="noopener noreferrer"><i class="fab fa-github"></i> GitHub</a></li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="footer-divider"></div>

        <!-- Footer Bottom com Créditos -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>
                    &copy; <?= date('Y') ?> <strong><?= App::getName() ?></strong>. Todos os direitos reservados.
                </p>
                
                <!-- Botão de Créditos - Jose Augusto Alves -->
                <a href="https://josealvesdev.com/" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="footer-credits-btn">
                    <span class="credit-code">&lt;/&gt;</span>
                    <span class="credit-name">Jose Augusto Alves</span>
                    <i class="fas fa-arrow-right credit-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

<script src="<?= App::getBasePath() ?>/public/js/main.js"></script>
</body>
</html>