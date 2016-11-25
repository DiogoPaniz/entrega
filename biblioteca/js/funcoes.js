/*******************************************************************************
 funcoes.js
 - function confirma(confirmMsg)
 - function alerta(confirmMsg)
 - function soInteiro(val)
 - function abrePopup(url,nome,w,h,s)
 - function validaForm(formulario)
 *******************************************************************************/
<<<<<<< HEAD
function ajuda(confirmMsg){ 
	return alert (confirmMsg);
}
 
function fechar(confirmMsg){ 
>>>>>>> cristiano-ramo
	return alert (confirmMsg);
}
<<<<<<< HEAD
 function desliga(confirmMsg){ 
	return alert (confirmMsg);;
}
 
=======
function liga(confirmMsg){
    return confirm(confirmMsg);
} 

>>>>>>> diogo
function confirma(confirmMsg){
    return confirm(confirmMsg);
} 

function alerta(confirmMsg){ 
	return alert (confirmMsg);;
}

//basta colocar esse evento en um campo qualquer: onKeyPress="soInterio(this)"
function soInteiro(val){
	carac = event.keyCode;
	if (!(carac>=48 && carac<=57)){//numéricos ASCII in[48,49,50,51,52,53,54,55,56,57,46])
		 event.keyCode = 0;
	} 
}

function abrePopup(url,nome,w,h,s){
	janela = window.open(url,nome,'width='+w+',height='+h+',top=1,left=1,scrollbars='+s+',toolbar=no,menubar=no,status=no,location=no,resizable=no');
	janela.focus();
}

/* 
Para validar os campos é preciso incluir no formulário:
<form ... onSubmit="return validaForm(this)" ...>
por exemplo:
<input type="text" title="Campo Text em branco" name="textfield" />
<input type="email" title="Campo E-mail em branco verificando e-mail" name="textfield" />
</form>
*/
function validaForm(formulario){
alert(formulario[i].required);
  for(i=0;i<=formulario.length-1;i++){
	if ((formulario[i].type=="textarea")||(formulario[i].type=="file")||
	    (formulario[i].type=="hidden")||(formulario[i].type=="text")||
	    (formulario[i].type=="password")||(formulario[i].type=="email")){
		
	    if ((formulario[i].title!="")&&(formulario[i].title!=undefined)){
			if (formulario[i].type=="email"){
				
				if((formulario[i].value=="")||
				(formulario[i].value.indexOf('@')==-1)||
				(formulario[i].value.indexOf('.')==-1)){
					alert(formulario[i].title);
					try{
						formulario[i].style.border = '2px solid #f00'; 						
						formulario[i].focus();
					}
					catch(e){
					}				
				    return false;
				}	
			}else{
				if(formulario[i].value==""){
					alert(formulario[i].title);
					try{
						formulario[i].style.border = '2px solid #f00'; 						
						formulario[i].focus();
					}
					catch(e){
					}		
					return false;
				}
			}
		}
	}	
  }
  return true;
}