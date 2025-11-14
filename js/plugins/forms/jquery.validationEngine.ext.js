//FUNCAO QUE VAI REDIRECIONAR PARA AS FUNÇÕES ValidaCpf ou ValidaCnpj, 
//DEPENDENDO DO TAMANHO DO CAMPO cpfCnpj
function VerificaCnpjCpf(field, rules, i, options){
    cnpjCpf = field.val();
    cnpjCpf = cnpjCpf.replace(/\.|-|\//gi,''); // elimina .(ponto), -(hifem) e /(barra)
    if (cnpjCpf.length <= 11)
        return ValidaCpf(field, rules, i, options)
    else
        return ValidaCnpj(field, rules, i, options)
}

//FUNÇÃO QUE VALIDA CPF
function ValidaCpf(field, rules, i, options){
    cpf = field.val();
    cpf = cpf.replace(/\.|-|\//gi,''); // elimina .(ponto), -(hifem) e /(barra)
    if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
            return options.allrules.cpf.alertText;
    add = 0;
    for (i=0; i < 9; i ++) add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11) rev = 0;
    if (rev != parseInt(cpf.charAt(9))) return options.allrules.cpf.alertText;
    add = 0;
    for (i = 0; i < 10; i ++) add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11) rev = 0;
    if (rev != parseInt(cpf.charAt(10))) return options.allrules.cpf.alertText;
}

//FUNÇÃO QUE VALIDA CNPJ
function ValidaCnpj(field, rules, i, options){
    cnpj=field.val();
    cnpj=cnpj.replace(/[\.\/\-]/g,'');
    var multipliers='543298765432';
    var sum=0;
    var str='';
    for (n=0;n<12;n++){
      sum+=(parseInt(cnpj.substr(n,1))*parseInt(multipliers.substr(n,1)));
      str+=cnpj.substr(n,1);
    }
    var dig1=parseInt(sum%11);
    dig1=(dig1<2?0:11-dig1);
    str+=String(dig1);
    multipliers='6'+multipliers;
    sum=0;
    for (n=0;n<13;n++) sum+=(parseInt(str.substr(n,1))*parseInt(multipliers.substr(n,1)));
    var dig2=parseInt(sum%11);
    dig2=(dig2<2?0:11-dig2);
    if (cnpj.substr(-2,2)!=(String(dig1)+String(dig2))) return options.allrules.cnpj.alertText;
}
