/**
 * public/js/acessibilidade.js
 * Menu de acessibilidade do ProjetoBase. As preferências ficam no navegador (localStorage)
 * e são aplicadas antes da página aparecer pelo script inline do layouts/header.php.
 *
 * Atributos no <html>:
 *   data-tema="escuro"          -> inverte as cores (imagens/vídeos são desinvertidos no CSS)
 *   data-cor="protanopia|..."   -> filtro de correção de cor (daltonização)
 *   data-contraste="alto"
 *   data-links="destacar"
 *   style.fontSize              -> tamanho base do texto (rem)
 */
(function () {
    'use strict';

    var CHAVE = 'pb-acessibilidade';
    var FONTE = { min: -2, max: 4, passo: 12.5 }; // 75% a 150%
    var html = document.documentElement;
    var padrao = { tema: 'claro', fonte: 0, cor: 'normal', contraste: false, links: false };

    function ler() {
        try {
            var salvo = JSON.parse(localStorage.getItem(CHAVE) || '{}');
            return Object.assign({}, padrao, salvo);
        } catch (e) {
            return Object.assign({}, padrao);
        }
    }

    function salvar(p) {
        try { localStorage.setItem(CHAVE, JSON.stringify(p)); } catch (e) { /* modo privado: só vale nesta página */ }
    }

    var pref = ler();

    function aplicar() {
        window.pbAplicarAcessibilidade(pref);   // definido no header.php (mesma lógica usada antes de pintar)

        // Estado dos botões
        document.querySelectorAll('[data-a11y]').forEach(function (b) {
            var tipo = b.getAttribute('data-a11y');
            var valor = b.getAttribute('data-valor');
            if (tipo === 'tema' || tipo === 'cor') {
                b.setAttribute('aria-pressed', String(pref[tipo] === valor));
            } else if (tipo === 'contraste' || tipo === 'links') {
                b.setAttribute('aria-pressed', String(!!pref[tipo]));
            }
        });
        var saida = document.getElementById('pbA11yFonteValor');
        if (saida) { saida.textContent = (100 + pref.fonte * FONTE.passo) + '%'; }
    }

    // ------------------------------------------------------------
    // Abrir / fechar painel (teclado: Esc fecha e devolve o foco)
    // ------------------------------------------------------------
    var botao = document.getElementById('pbA11yToggle');
    var painel = document.getElementById('pbA11yPainel');
    if (!botao || !painel) { return; }

    function abrir() {
        painel.hidden = false;
        botao.setAttribute('aria-expanded', 'true');
        var primeiro = painel.querySelector('button');
        if (primeiro) { primeiro.focus(); }
    }

    function fechar(devolverFoco) {
        painel.hidden = true;
        botao.setAttribute('aria-expanded', 'false');
        if (devolverFoco) { botao.focus(); }
    }

    botao.addEventListener('click', function () {
        painel.hidden ? abrir() : fechar(true);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !painel.hidden) { fechar(true); }
    });

    document.addEventListener('click', function (e) {
        if (!painel.hidden && !painel.contains(e.target) && !botao.contains(e.target)) { fechar(false); }
    });

    painel.querySelector('[data-a11y-fechar]').addEventListener('click', function () { fechar(true); });

    // ------------------------------------------------------------
    // Ações
    // ------------------------------------------------------------
    painel.addEventListener('click', function (e) {
        var b = e.target.closest('[data-a11y]');
        if (!b) { return; }
        var tipo = b.getAttribute('data-a11y');
        var valor = b.getAttribute('data-valor');

        if (tipo === 'tema' || tipo === 'cor') {
            pref[tipo] = valor;
        } else if (tipo === 'fonte') {
            var delta = parseInt(valor, 10);
            pref.fonte = delta === 0 ? 0 : Math.min(FONTE.max, Math.max(FONTE.min, pref.fonte + delta));
        } else if (tipo === 'contraste' || tipo === 'links') {
            pref[tipo] = !pref[tipo];
        } else if (tipo === 'resetar') {
            pref = Object.assign({}, padrao);
        }

        salvar(pref);
        aplicar();
    });

    aplicar();
})();
