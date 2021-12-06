function exibeMsgModal(msg, reload) {
    let modal = document.getElementById("myModal");
    let modal_content = document.getElementById("modal-content");

    modal_content.innerHTML = "<p>" + msg + "</p>";
    modal.style.display = "block";
    window.onclick = function(event) {
        if(event.target == modal) {
            modal.style.display = "none";
            if(reload) window.location.reload(true);
        }
    }
}

function enviaPost(url, body, reload=false) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.send(JSON.stringify(body));

    xhr.onload = function() {
        exibeMsgModal(this.responseText, reload);
    }
    return xhr.status;
}

function addIngrediente() {
    let url = 'add-ingrediente';
    let nome = document.getElementById("nome").value;
    let peso = document.getElementById("peso").value;
    let preco_kg = document.getElementById("preco_kg").value;

    console.log(nome + " " + peso + " " + preco_kg);
    let body = {
        "nome": nome,
        "peso": peso,
        "preco_kg": preco_kg
    };
    enviaPost(url, body);
    document.getElementById("nome").value = '';
    document.getElementById("peso").value = '';
    document.getElementById("preco_kg").value = '';
}

function addReceita() {
    let nome = document.getElementById("nome").value
    let preco = document.getElementById("preco").value
    let ingredientes = ''
    let url = 'add-receita'

    let checks = document.getElementsByClassName("opcao-check")
    let qtd_forms = document.getElementsByClassName("opcao-qtd")
    for(let i = 0; i < checks.length; i++) {
        if(checks[i].checked)
            ingredientes += checks[i].id + ',' + qtd_forms[i].value + ','
    }
    ingredientes = ingredientes.substring(0, ingredientes.length-1)
    
    let body = {
        "nome": nome,
        "preco": preco,
        "ingredientes": ingredientes
    }
    if(body.ingredientes === '') {
        exibeMsgModal("A receita precisa ter algum ingrediente.");
        return;
    }
    enviaPost(url, body);
    document.getElementById("nome").value = '';
    document.getElementById("preco").value = '';

    for(let i = 0; i < checks.length; i++) {
        document.getElementsByClassName("opcao-check")[i].checked = false;
        document.getElementsByClassName("opcao-qtd")[i].value = '';
    }
}


function excluirIngrediente(id, nome) {
    let modal = document.getElementById("modal-exclusao");
    let modal_content = document.getElementById("modal-exclusao-content");

    modal_content.innerHTML = "<p> Excluir " + nome + " ? </p><br>";
    modal_content.innerHTML += "<button id='excluir-ingrediente' class='botao-excluir'>Excluir</button>";
    modal.style.display = "block";

    document.getElementById('excluir-ingrediente').onclick = function(event) {
        modal.style.display = "none";

        let url = 'remover-ingrediente';
        let body = {
            'id': id,
            'nome': nome
        }
        enviaPost(url, body, true);
    }
    window.onclick = function(event) {
        if(event.target == modal)
            modal.style.display = "none";
    }
}

function excluirReceita(id, nome) {
    let modal = document.getElementById("modal-exclusao");
    let modal_content = document.getElementById("modal-exclusao-content");

    modal_content.innerHTML = "<p> Confirmar excluir<p style='color:green'>" + nome + "</p></p><br>";
    modal_content.innerHTML += "<button id='excluir-receita' class='botao-excluir'>Excluir</button>";
    modal.style.display = "block";

    document.getElementById('excluir-receita').onclick = function(event) {
        modal.style.display = "none";
        
        let url = 'remover-receita';
        let body = {
        'id': id,
        'nome': nome
        }
        enviaPost(url, body, true);
    }
    window.onclick = function(event) {
        if(event.target == modal)
            modal.style.display = "none";
    }
}

function registrarVenda(id, nome) {
    let modal = document.getElementById("modal-exclusao");
    let modal_content = document.getElementById("modal-exclusao-content");

    modal_content.innerHTML = "<p> Confirmar registrar<p style='color:green'>" + nome + "</p></p><br>";
    modal_content.innerHTML += "<button id='registrar-receita' class='botao-registrar'>Registrar</button>";
    modal.style.display = "block";

    document.getElementById('registrar-receita').onclick = function(event) {
        modal.style.display = "none";
        
        let url = 'registrar-venda';
        let body = {
        'id': id,
        'nome': nome
        }
        enviaPost(url, body, true);
    }
    window.onclick = function(event) {
        if(event.target == modal)
            modal.style.display = "none";
    }
}

function mostrarPrato(id) {
    let body = {
        'id': id
    };
    let url = 'info-receita';
    enviaPost(url, body);
}

let checks = document.getElementsByClassName("opcao-check")
let qtd_forms = document.getElementsByClassName("opcao-qtd")
if(checks.length > 0 && qtd_forms.length > 0) {
    for(let i=0; i< checks.length; i++) {
        checks[i].onchange = function() {
            qtd_forms[i].disabled = !checks[i].checked
        }
    }
}