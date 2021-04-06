var validarEmail=function(email){
    let regex=/^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    if(regex.test(email)){
        return true;
    }else{
        return false;
    }
}

var validarPass=function(password){
    let regex=/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/;
    if(regex.test(password)){
        return true;
    }else{
        return false;
    }
}
