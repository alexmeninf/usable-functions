<?php 

if ( ! defined( 'ABSPATH' ) ) 
	exit;


if ( ENABLE_COLOR_SCHEME_MODE === false )
  return;

/** 
 * Carregar stylesheet
 */

function enqueue_color_scheme()
{
  wp_enqueue_style('color-scheme-mode', STYLESHEET . '/assets/css/mode-appearance.css');
}

add_action('wp_enqueue_scripts', 'enqueue_color_scheme');



/**
 * Adicionar uma metatag no cabeçalho do nosso HTML
 * 
 * Isso funcionará como um substituto para o navegador, caso não tenha
 * prefers-color-scheme, uma vez que pode atuar como um indicador para 
 * o navegador saber que o conteúdo oferece suporte a esquemas de cores.
 * 
 */

function head_color_scheme()
{
  echo '<meta name="color-scheme" content="dark light">';
}

add_action('wp_head', 'head_color_scheme', 1);



/**
 * 
 * Adicionar o script no final da página.
 * 
 * Sem o JavaScript, o visitante não será capaz de interagir com a página, 
 * com o script será permindo ele definir o modo e ser salvo no navegador as suas preferências.
 * 
 */

function footer_color_scheme()
{ ?>
  <script>
    const toggleColourModeBtn = document.getElementById("modeAppearance");
    const currentColourMode = localStorage.getItem("colourMode");
    const sysIsDark = window.matchMedia("(prefers-color-scheme: dark)").matches; // Verifica se o SO está escuro
    const sysIsLight = window.matchMedia("(prefers-color-scheme: light)").matches; // Verifica se o SO está claro

    getSavedColourMode(currentColourMode);
    toggleCheckedMode();

    toggleColourModeBtn.addEventListener("change", function() {
      toggleColourMode();
      setAndSaveColourMode();
    });

    function getMode() {
      return document.body.getAttribute('data-color-scheme');
    }
    
    function setMode(value) {
      document.body.setAttribute('data-color-scheme', value);
    }

    /**
     * Verifica se o tema está escuro
     */
    function isDark() {
      const hasSysDarkClass = getMode() == 'auto';
      const currentSysIsDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
      const isDark = (hasSysDarkClass && currentSysIsDark) || getMode() == 'dark';

      return isDark;
    }

    /**
     * Mudar o modo da aparencia pelo valor salvo no navegador
     */
    function getSavedColourMode(savedMode) {
      if (localStorage.getItem("overRideSysColour") == "true") {
        setMode(savedMode);
      }
    }

    /**
     * Alterar modo da aparencia
     */
    function toggleColourMode() {
      var ele = document.getElementsByName('mode');

      for (i = 0; i < ele.length; i++) {
        if (ele[i].checked)
          setMode(ele[i].value);
      }
    }

    /**
     * Salvar no localStorage e alterar layout
     */
    function setAndSaveColourMode() {
      let colourMode;

      switch (getMode()) {
        case 'dark':
          colourMode = "dark";
          break;
        case 'light':
          colourMode = "light";
          break;
        default:
          colourMode = "auto";
          break;
      }

      localStorage.setItem("colourMode", colourMode);
      localStorage.setItem("overRideSysColour", "true")
    }

    /** 
     * Define na input o valor marcado.
     */
    function toggleCheckedMode() {
      let ele = document.getElementsByName('mode');

      for (i = 0; i < ele.length; i++) {
        if (ele[i].value == getMode()) {
          ele[i].checked = true;
        } else {
          if (ele[i].hasAttribute('checked')) {
            ele[i].removeAttribute('checked');
          }
        }
      }
    }
  </script>
<?php
}

add_action('wp_footer', 'footer_color_scheme');



/**
 * 
 * Criar shortcode do switch
 * 
 */

function callback_template_scheme()
{ ?>
  <form 
    id="modeAppearance" 
    aria-label="<?php _e('Selecione a aparência do site', 'menin') ?>" 
    role="radiogroup" 
    tabindex="0" 
    class="color-scheme-toggle">
    <label>
      <input name="mode" type="radio" value="light">
      <div class="text"><?php _e('Clara', 'menin') ?></div>
    </label>
    <label>
      <input name="mode" type="radio" value="dark">
      <div class="text"><?php _e('Escura', 'menin') ?></div>
    </label>
    <label>
      <input name="mode" type="radio" value="auto" checked>
      <div class="text">Auto</div>
    </label>
  </form>
<?php
}

add_shortcode('color_scheme_toggle', 'callback_template_scheme');
