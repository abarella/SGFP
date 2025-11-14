/**
 * Valida o JSON
 * @param {type} string
 * @returns {Boolean}
 */
function isValidJSON(string) {
    try {
        if (string.constructor == Object)
            return true;

        JSON.parse(string);
    } catch (e) {
        return false;
    }

    return true;
}
/* Transforma os errros JSON em HTML */
function jsonErrorsToHtml(json) {
    var html = '<div class="list body text-error"><ul>';

    $.each(json, function (i, p) {
        if (typeof p == "string")
            html += '<li>' + p + '</li>';
        else
            $.each(p, function (i, s) {
                if (typeof s == "string")
                    html += '<li>' + s + '</li>';
                else
                    $.each(s, function (i, t) {
                        html += '<li>' + t + '</li>';
                    });
            });
    });

    html += '</ul></div>';

    return html;
}

function limpaSelectUniform(container) {
    $(container).find("div[id^=uniform] select").each(function (i, el) {
        $.uniform.restore(el);

        $(el).removeData("has-uniform-enabled");
    });
}

function limpaSelect2(container) {
    container.find(".select2-container").remove();
    container.find("select.select").removeData("select2").removeData("hasSelectEnabled");
}

function limpaDatepicker(container) {
    var inputs = container.find(".datepicker");
    inputs.removeClass("hasDatepicker")
}

/* A funcao cria um guid seguindo a rfc4122 version 4 */
function createGuid()
{
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

/**
 * Visualizar imagem pelo lightbox
 */
$(function () {
    $(".lightbox").fancybox({
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 600,
        'speedOut': 200,
        'overlayShow': false
    });
});


/**
 * A funcao remove o atributo disabled de todos os inputs, select e radios da linha referenciada 
 *  
 * @param ref Referencia do elemento com os inputs, select e radios
 */
function enableLineInputs(ref) {
    var inputs = $(ref).find("input, select, radio");
    $.each(inputs, function () {
        $(this).removeAttr("disabled");
    });
}

/* Clone */
var fnBtClickClone = function (event) {
    event.preventDefault();

    if ($(this).is(".disabled"))
        return false;

    $(this).addClass(".disabled")

    var configs = {"direction": "up"};

    try {
        $.extend(configs, $(this).data("th-bt-clone"));
    } catch (e) {
        configs = $.extend(configs, {table: $(this).closest("table")});
    }

    var tb = $(configs.table);

    var tbody = tb.children("tbody");
    var hiddenTr = tbody
            .children("tr.hidden,tr:hidden")
            .not('tr:has(td[class^=details_row])') // evita pegar subgrid
            .filter(configs.direction == "down" ? ":last" : ":first");

    if (hiddenTr.length > 0) {
        var newTr = tbody.children("tr.hidden,tr:hidden")
                .not("tr:has(td[class^=details_row])")
                .filter(":first");

        // Se os campos estiverem desabilitados, os habilita
        $("input:disabled, select:disabled, radio:disabled", newTr).each(function (index, el) {
            $this = $(this);
            $this.removeAttr("disabled");
            $this.removeClass("hasTooltip");
            if ($this.hasClass("styled")) {
                $.uniform.update($this);
            }
        });

        newTr.removeClass("hidden").show();
    } else {
        var firstTr = tbody.children("tr:not([class^=details_row])").filter(":first");
        var inputs = $(":input:enabled", firstTr);

        if (inputs.length == 0)
            return false;

        if (configs.validate && configs.validate == true)
            if ($(this).closest("form").data("validator") && !inputs.valid())
                return false;

        var newTr = firstTr.clone();
        var newInputs = newTr.find(":input");

        switch (configs.direction) {
            case "down":
                tb.children("tbody").append(newTr);
                break;
            default:
                tb.children("tbody").prepend(newTr);
        }

        // Limpa os campos de validação
        $(":input", newTr).validationEngine('hide');

        var prefix = function (el, attr) {
            var prefix = new String('');
            var elId = el.attr(attr);

            for (i = elId.length - 1; i > 0; i--) {
                if (attr == "name" && elId[i] == "]")
                    continue;

                if (isNaN(elId[i])) {
                    prefix = elId.substring(0, (elId[i] == "-" ? i + 1 : i));
                    break;
                }
            }

            return prefix;
        }


        newTr.find("*").each(function (i, el) {
            var nEl = $(el);
            nEl.removeData();

            if (nEl.attr("id") && nEl.attr("id").length > 0) {
                var newElId = prefix(nEl, "id");
                nEl.attr("id", newElId + new String($("[id^=" + newElId + "]").length - 1));
            }
            //nEl.attr("id", nEl.attr("id").replace(/[0-9]+/g, '') + ($("[id^=" + nEl.attr("id").replace(/-?[0-9]+/g, '') + "]").length - 1))

            if (nEl.attr("name") && nEl.attr("name").length > 0) {
                var novoNome = prefix(nEl, "name");

                nEl.attr("name", novoNome + "[" + new String($("[name^=" + novoNome.replace(/\[/g, "\\[").replace(/\]/g, "\\]") + "]").length - 1) + "]");
            }

            if (nEl.data("original-title"))
                nEl.attr("title", nEl.data("original-title")).removeData("original-title")

            if (nEl.is(":input")) {
                if (nEl.is(".styled")) {
                    $.uniform.restore(nEl);
                }

                if ($(el).is(":radio"))
                    $(el).removeAttr("checked");
                else
                    $(el).val("");
            }

            nEl.removeClass("hasTooltip");
        });

        if (configs.callback) {
            eval(configs.callback).call(this, newTr);
        }

        //newInputs.val("")
        if (newInputs)
            newInputs.change();
    }

    $(this).removeClass(".disabled")
    $("body").trigger("change")
};

/** verifica hora válida */
function fnVerificaHora(value)
{
    var tempo = value.split(':');

    if (tempo[0] > 23 || tempo[1] > 59) {
        return false;
    }
    return true;
}

/* Valida data */
function dataValida(value) {
    if (value.length != 10)
        return false;
    // verificando data   
    var data = value;
    var dia = data.substr(0, 2);
    var barra1 = data.substr(2, 1);
    var mes = data.substr(3, 2);
    var barra2 = data.substr(5, 1);
    var ano = data.substr(6, 4);
    if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12) {
        return false;
    }
    if (dia == 0 || mes == 0 || ano == 0)
        return false;
    if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31)
        return false;
    if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0)))
        return false;
    return true;
}


//----------------------------------------------------------------------------------
// ABRE O MODAL PARA VISUALIZAR O GALPÃO SELECIONADO 
// Parametros:
// - idConfiguracaoGalpao => id do galpão
// - tpArmazenamento => tipo de armazenamento (BL, CO, CX, SC, FR, LT). 
//   Este parâmetro é opcional para o tipo de galpão for 'Rejeito Não Tratado' (RN)
//   Quando for opcional coloca-se um parametro qualquer.
// - visualizar => Opção para o modo que será montado o galpão para visualizaçao
//   1 -> So vai visualizar.
//   0 -> Além de visualizar, poderá selecionar uma posição para gravação
// - idPosicaoGalpao => Este parâmetro serve para focar em qual lugar está o armazenamento com 
//   a posição (linha X coluna), nível e armazenamento.
fnVisualizarGalpao = function (idConfiguracaoGalpao, tpArmazenamento, visualizar, idPosicaoGalpao) {

    var url = [baseUrl, moduleName, 'tratar-rejeitos', 'visualizar-galpao', 'idConfiguracaoGalpao', idConfiguracaoGalpao, 'tpArmazenamento', tpArmazenamento, 'visualizar', visualizar, 'idPosicaoGalpao', idPosicaoGalpao].join("index.html");

    // Verifica se existe os parametros necessários para visualizar o galpão
    if (idConfiguracaoGalpao != "" && tpArmazenamento != "") {

        $.get(url, function (html) {
            var janela = bootbox.dialog(html, [{
                    "label": "Voltar",
                    "className": "my-modal",
                    "class": "tip btn-success",
                    "title": "Voltar",
                    "id": "btnVoltar",
                    "callback": function () {
                        $(janela).modal('hide');

                        // LIMPA OS HIDDENS DE POSIÇÃO DE GALPÃO
                        fnLimpaPosicoesGalpao();

                        return false;
                    }
                }], {classes: 'modal-large'});
        });
    }

};

//----------------------------------------------------------------------------------
// FUNÇÃO PARA LIMPAR OS HIDDENS DAS POSIÇÕES (HIDDENS) 
function fnLimpaPosicoesGalpao() {
    $('body').find('#cdLinha, #cdColuna, #cdPosicao, #cdPrateleira, #cdNivel').val("");
}

//===== Configurações das requisições Ajax  =====//

$(document).ajaxSend(function (event, request, settings) {
    var botao = settings.botao;
    // Se o botao for informado o desabilita para evitar mais de uma requisição
    if (botao != null) {
        botao.attr("disabled", "disabled");
    }
});

$(document).ajaxComplete(function (event, xhr, settings) {
    var botao = settings.botao;
    // Se o botão for especificado ao termino da requisição o reabilita
    if (botao != null) {
        botao.removeAttr("disabled");
    }
});

$.ajaxSetup({
    beforeSend: function (jqXHR, settings) {
        var botao = settings.botao;
        // Se o botão estiver desabilitado não faz a requisição
        if (botao != null) {
            if (botao.attr("disabled") === "disabled")
                jqXHR.abort();
        }
    },
    cache: false,
    error: function (jqXHR, textStatus) {
        if (textStatus == "error" && jqXHR.responseText.length > 0) {
            var html = '';
            try {
                html = (JSON.parse(jqXHR.responseText)).message;
            } catch (e) {
                html = jqXHR.responseText;
            }

            bootbox.alert(html);
        }
    }
});

function setInputsIdIndex(id, context) {
    $(":input", context).each(function (i, el) {
        var lastIndex = el.id.lastIndexOf("-");
        var oldId = el.id.substring(lastIndex + 1).replace(/[^0-9]/ig, "");

        if (parseInt(oldId) >= 0) {
            el.id = el.id.substring(0, lastIndex + 1) + id;
        }
    })
}

function queryStringToArray(n, s) {
    // extract out the parameters
    n = n.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var p = (new RegExp("[\\?&]" + n + "=([^&#]*)")).exec(s);
    return (p === null) ? "" : p[1];
}


$(function () {
//===== Collapsible plugin for main nav =====//
    var container = $("ul.navigation");

    $('ul.navigation > li > a').click(function (event) {
        var a = $("a.subOpened:visible").not(this);
        a.click().removeClass("subOpened").addClass("subClosed");
        $("li.active").not($(this).closest("li.active")).removeClass("active")
    });

    container.find(".expand").collapsible({
        cookieName: 'navAct',
        cssOpen: 'subOpened',
        cssClose: 'subClosed',
        speed: 200
    });

    $("a.active", container).parentsUntil(container).each(function (i, el) {
        if ($(el).is("li")) {
            $(el).addClass("active");

            $(el).find("a.subClosed").removeClass("subClosed").addClass("subOpened");
        }
        else {
            if ($(el).is("ul"))
                $(el).show();
        }
    });

    //===== Tooltips && select2 =====//
    $("body").on("mouseout mouseover load change", function (event) {
        /* Tooltip */
        $(".tip:not(.hasTooltip)").each(function (i, el) {
            var configs = ($(el).is("[data-tooltip-config]")
                    ? $(el).data("tooltip-config")
                    : {});

            $(el).addClass("hasTooltip").tooltip(configs).on('show', function (e) {
                if ($(this).closest(".modal").length > 0)
                    e.stopPropagation();
            }).on('hidden', function (e) {
                if ($(this).closest(".modal").length > 0)
                    e.stopPropagation();
            });
            ;
        });

        /* Select2 */
        $(".select,.select2").filter(function () {
            return ($(this).data("has-select-enabled") != null ? false : this);
        }).each(function (i, el) {
            var configs = ($(el).is("[data-select2-config]")
                    ? $(el).data("select2-config")
                    : {});

            $(el).data("has-select", true).addClass("hasSelect").select2(configs);
        });

        /* Uniform JS */
        $(".form-uniform :input.styled, :input.upload").filter(function () {
            return ($(this).data("has-uniform-enabled") != null ? false : this);
        }).each(function (i, el) {
            $(el).data("has-uniform-enabled", true);

            var configs = ($(el).is("[data-uniform-config]")
                    ? $(el).data("uniform-config")
                    : {selectAutoWidth: false});

            $(el).uniform(configs);
        });

        /* Mask Money JS */
        $("[data-mask-money]").filter(function () {
            return ($(this).data("has-mask-money-enabled") != null ? false : this);
        }).each(function (i, el) {
            $(el).data("has-mask-money-enabled", true);

            var configs = (
                    isValidJSON($(el).data("mask-money"))
                    ? $(el).data("mask-money")
                    : (isValidJSON($(el).data("mask-money-config"))
                            ? $(el).data("mask-money-config")
                            : {thousands: '', decimal: ',', allowZero: true}))

            $(el).addClass("align-right");
            $(el).maskMoney(configs);
        });

        /* Adiciona o datepicker */
        $(".datepicker:not(.hasDatepicker)").each(function (i, el) {

            var configs = ($(el).is("[data-datepicker-config]")
                    ? $(el).data("datepicker-config")
                    : {defaultDate: null,
                        showOtherMonths: true,
                        showMonthAfterYear: true,
                        autoSize: true,
                        dateFormat: 'dd/mm/yy',
                        navigationAsDateFormat: true});

            $(el).datepicker(configs);
            $(el).addClass("hasDatepicker");
        });

        /* Adiciona Popover */
        $(".popOver,[data-toggle=popover]").not('.hasPopOver').each(function (i, el) {
            var configs = {placement: "top", trigger: "hover"};
            
            try {
                $.extend(configs, $(this).data());
            } catch (e) {

            }

            $(el).popover(configs);
            $(el).addClass("hasPopOver");
        });

        $("[data-th-bt-clone]").filter(function () {
            return ($(this).data("data-th-bt-clone-on") != null ? false : this);
        }).each(function (i, el) {
            $(el).data("data-th-bt-clone-on", true);
            $(el).click(fnBtClickClone);
        });
    });
    //===== InputMask =====//
    $.extend($.fn.inputmask.defaults.definitions, {
        "5": "[0-5]",
        "n": "[0-9.]",
        "1": "[0-9%]",
        "¬": "[+-]",
        "2": "[0-2]",
        "3": "[0-3]",
        "§": "[a-z A-Z]",
        "£": "[0-9 ]"
    });

    //=====  Validation engine custom validation =====//
    $.extend($.validationEngineLanguage.allRules, {
        "timeFormatHi": {
            "regex": /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
            "alertText": "A hora informada deve ser válida"
        },
        "date": {
            "regex": /^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/,
            "alertText": "* Data inválida, deve ser no formato DD/MM/AAAA"
        }
    });

    /* Remove a mascara de campos desabilitados e readOnly */
    $("input:disabled, input[readonly='readonly'], :not(.data-mask-removed)").each(function () {
        //$("#").inputmask('remove');
    });

    $("body").trigger("load");
});

//===== Configurações das requisições Ajax  =====//

$(document).ajaxSend(function (event, request, settings) {
    var botao = settings.botao;
    // Se o botao for informado o desabilita para evitar mais de uma requisição
    if (botao != null) {
        botao.attr("disabled", "disabled");
    }
});

$(document).ajaxComplete(function (event, xhr, settings) {
    var botao = settings.botao;
    // Se o botão for especificado ao termino da requisição o reabilita
    if (botao != null) {
        botao.removeAttr("disabled");
    }
});

$.ajaxSetup({
    beforeSend: function (jqXHR, settings) {
        var botao = settings.botao;
        // Se o botão estiver desabilitado não faz a requisição
        if (botao != null) {
            if (botao.attr("disabled") === "disabled")
                jqXHR.abort();
        }
    },
    cache: false,
    error: function (jqXHR, textStatus) {
        if (textStatus == "error" && jqXHR.responseText.length > 0) {
            var html = '';
            try {
                html = (JSON.parse(jqXHR.responseText)).message;
            } catch (e) {
                html = jqXHR.responseText;
            }

            bootbox.alert(html);
        }
    }
});