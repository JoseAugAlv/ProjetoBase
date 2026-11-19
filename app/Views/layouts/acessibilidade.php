<?php
// app/Views/layouts/acessibilidade.php
// Menu de acessibilidade (tema escuro, tamanho do texto, cores para daltônicos,
// alto contraste, destacar links) + VLibras. Incluído pelo footer.php.
// Liga/desliga em app/Config/modules.php: 'acessibilidade' e 'vlibras'.

if (MenuHelper::isModuleEnabled('acessibilidade')):
?>
<!-- Filtros SVG de correção de cor (daltonização) usados pelo modo "Cores" -->
<svg aria-hidden="true" focusable="false" style="position:absolute;width:0;height:0;overflow:hidden">
    <filter id="pb-protanopia" color-interpolation-filters="linearRGB">
        <feColorMatrix type="matrix" values="1 0 0 0 0  -0.255 1.255 0 0 0  0.303 -0.545 1.242 0 0  0 0 0 1 0"/>
    </filter>
    <filter id="pb-deuteranopia" color-interpolation-filters="linearRGB">
        <feColorMatrix type="matrix" values="1 0 0 0 0  -0.438 1.438 0 0 0  0.263 -0.563 1.3 0 0  0 0 0 1 0"/>
    </filter>
    <filter id="pb-tritanopia" color-interpolation-filters="linearRGB">
        <feColorMatrix type="matrix" values="1.05 -0.383 0.333 0 0  0 1.235 -0.235 0 0  0 0 1 0 0  0 0 0 1 0"/>
    </filter>
</svg>

<div class="pb-a11y" data-no-invert>
    <button type="button" class="pb-a11y-toggle" id="pbA11yToggle"
            aria-label="Abrir menu de acessibilidade" aria-expanded="false" aria-controls="pbA11yPainel"
            title="Acessibilidade">
        <i class="fas fa-universal-access" aria-hidden="true"></i>
    </button>

    <div class="pb-a11y-painel" id="pbA11yPainel" role="dialog" aria-modal="false" aria-labelledby="pbA11yTitulo" hidden>
        <div class="pb-a11y-cabecalho">
            <h2 id="pbA11yTitulo"><i class="fas fa-universal-access" aria-hidden="true"></i> Acessibilidade</h2>
            <button type="button" class="pb-a11y-fechar" data-a11y-fechar aria-label="Fechar menu de acessibilidade">&times;</button>
        </div>

        <div class="pb-a11y-grupo" role="group" aria-labelledby="pbA11yTema">
            <span class="pb-a11y-rotulo" id="pbA11yTema">Tema</span>
            <div class="pb-a11y-opcoes">
                <button type="button" data-a11y="tema" data-valor="claro" aria-pressed="true"><i class="fas fa-sun" aria-hidden="true"></i> Claro</button>
                <button type="button" data-a11y="tema" data-valor="escuro" aria-pressed="false"><i class="fas fa-moon" aria-hidden="true"></i> Escuro</button>
            </div>
        </div>

        <div class="pb-a11y-grupo" role="group" aria-labelledby="pbA11yFonte">
            <span class="pb-a11y-rotulo" id="pbA11yFonte">Tamanho do texto <output id="pbA11yFonteValor" aria-live="polite">100%</output></span>
            <div class="pb-a11y-opcoes">
                <button type="button" data-a11y="fonte" data-valor="-1" aria-label="Diminuir texto">A-</button>
                <button type="button" data-a11y="fonte" data-valor="0" aria-label="Tamanho padrão do texto">A</button>
                <button type="button" data-a11y="fonte" data-valor="1" aria-label="Aumentar texto">A+</button>
            </div>
        </div>

        <div class="pb-a11y-grupo" role="group" aria-labelledby="pbA11yCores">
            <span class="pb-a11y-rotulo" id="pbA11yCores">Cores (daltonismo)</span>
            <div class="pb-a11y-opcoes pb-a11y-opcoes-coluna">
                <button type="button" data-a11y="cor" data-valor="normal" aria-pressed="true">Cores normais</button>
                <button type="button" data-a11y="cor" data-valor="protanopia" aria-pressed="false">Protanopia <small>(vermelho)</small></button>
                <button type="button" data-a11y="cor" data-valor="deuteranopia" aria-pressed="false">Deuteranopia <small>(verde)</small></button>
                <button type="button" data-a11y="cor" data-valor="tritanopia" aria-pressed="false">Tritanopia <small>(azul/amarelo)</small></button>
                <button type="button" data-a11y="cor" data-valor="cinza" aria-pressed="false">Escala de cinza</button>
            </div>
        </div>

        <div class="pb-a11y-grupo" role="group" aria-label="Outras opções">
            <div class="pb-a11y-opcoes pb-a11y-opcoes-coluna">
                <button type="button" data-a11y="contraste" aria-pressed="false"><i class="fas fa-adjust" aria-hidden="true"></i> Alto contraste</button>
                <button type="button" data-a11y="links" aria-pressed="false"><i class="fas fa-link" aria-hidden="true"></i> Destacar links</button>
            </div>
        </div>

        <button type="button" class="pb-a11y-resetar" data-a11y="resetar"><i class="fas fa-undo" aria-hidden="true"></i> Restaurar padrão</button>
    </div>
</div>

<script src="<?= asset('js/acessibilidade.js') ?>"></script>
<?php endif; ?>

<?php if (MenuHelper::isModuleEnabled('vlibras')): ?>
<!-- VLibras (Governo Federal): tradução do conteúdo para Libras -->
<div vw class="enabled" data-no-invert>
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
        <div class="vw-plugin-top-wrapper"></div>
    </div>
</div>
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
    if (window.VLibras) { new window.VLibras.Widget('https://vlibras.gov.br/app'); }
</script>
<?php endif; ?>
