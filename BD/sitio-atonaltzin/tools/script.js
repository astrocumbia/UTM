/* NECESARIOS PARA LA VALIDACION */
var NUMEROS="123456789";
var ALFABETO="abcdefghyjklmnñopqrstuvwxyz";

/*  validar un nombre de usuario valido 
    solo letras de alfabeto */


function esNombreValido( nombre ){
    for( i=0; i<nombre.length; i++ ){
        if( ALFABETO.indexOf( nombre.charAt(i), 0 )!=-1 && nombre.charAt(i)!=" ")
            return false;
    }
    return true;
}

function estaVacio( valor ){
	if( valor.length == 0 )
		return true;
	return false;
}
