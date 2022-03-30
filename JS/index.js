var httpRequest;

function handleSubmit(){
    let cep = document.getElementById("cepField").value;
    let validacep = /^[0-9]{8}$/;

    if(cep == ""){
        alert("Por favor digite um CEP válido");
        return;
    }

    if(!validacep.test(cep)){
        alert('cep invalido');
    }

    //let url = "https://viacep.com.br/ws/" + cep + "/json/";

    let data = 'cep=' + cep;
    let url = "http://localhost/api-cep/PHP/?" + data;

    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE
    try {
        httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
        try {
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {}
    }
    }
  
    if (!httpRequest) {
    alert('Não foi possivel criar uma instancia do XMLHTTP');
    return false;
    }
    httpRequest.onreadystatechange = insertData;
    httpRequest.open('GET', url);
    httpRequest.send();

    var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
    var collapseList = collapseElementList.map(function (collapseEl) {
        return new bootstrap.Collapse(collapseEl)
    })
}

function insertData() {
    if (httpRequest.readyState === 4) {
        if (httpRequest.status === 200) {
            const data = JSON.parse(httpRequest.responseText);
            document.getElementById("rua").innerText = `Logradouro: ${data.rua}`;
            document.getElementById("bairro").innerText = `Bairro: ${data.bairro}`;
            document.getElementById("cidade").innerText = `Localidade: ${data.cidade} - ${data.uf}`;
            document.getElementById('rua').value = ("cepField");
        } else {
        alert('Tivemos um problema com a requisição.');
        }
    }
}