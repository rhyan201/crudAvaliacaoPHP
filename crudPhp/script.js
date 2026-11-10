//elementos pagina
const campoNome = document.getElementById('nome');
const campoDescricao = document.getElementById('descricao');
const campoNota = document.getElementById('nota');
const btnEnviar = document.getElementById('btn-enviar');
const lista = document.getElementById('lista_avaliacoes');

//id sendo alterado
let idEmEdicao = null;

if (lista) {
    carregarAvaliacoes();
    btnEnviar.addEventListener('click', salvarAvaliacao);
}


// ===== READ: busca as avaliações e monta a lista =====
async function carregarAvaliacoes() {
    const resposta = await fetch('crud/read_avaliacao.php');
    const json = await resposta.json();

    lista.innerHTML = '';

    if (json.status !== 'ok') {
        return;
    }

    json.data.forEach(function (avaliacao) {
        const li = document.createElement('li');

        const titulo = document.createElement('strong');
        titulo.textContent = avaliacao.nome;

        const nota = document.createElement('span');
        nota.textContent = ' — nota ' + avaliacao.nota;

        const descricao = document.createElement('p');
        descricao.textContent = avaliacao.descricao;

        const btnAlterar = document.createElement('button');
        btnAlterar.textContent = 'Alterar';
        btnAlterar.addEventListener('click', function () {
            prepararAlteracao(avaliacao);
        });

        const btnExcluir = document.createElement('button');
        btnExcluir.textContent = 'Excluir';
        btnExcluir.className = 'excluir';
        btnExcluir.addEventListener('click', function () {
            excluirAvaliacao(avaliacao.id);
        });

        li.append(titulo, nota, descricao, btnAlterar, btnExcluir);
        lista.appendChild(li);
    });
}


// ===== CREATE / UPDATE: envia o formulário =====
async function salvarAvaliacao() {
    // o FormData monta os dados no formato que o $_POST do PHP entende
    const dados = new FormData();
    dados.append('nome', campoNome.value);
    dados.append('descricao', campoDescricao.value);
    dados.append('nota', campoNota.value);

    // sem id em edição = cadastro novo; com id = alteração (id vai na URL)
    let url = 'crud/create_avaliacao.php';
    if (idEmEdicao !== null) {
        url = 'crud/update_avaliacao.php?id=' + idEmEdicao;
    }

    const resposta = await fetch(url, {
        method: 'POST',
        body: dados
    });
    const json = await resposta.json();

    alert(json.mensagem);

    if (json.status === 'ok') {
        limparFormulario();
        carregarAvaliacoes();
    }
}


//envia os dados para o form para alteraçao
function prepararAlteracao(avaliacao) {
    idEmEdicao = avaliacao.id;
    campoNome.value = avaliacao.nome;
    campoDescricao.value = avaliacao.descricao;
    campoNota.value = avaliacao.nota;
    btnEnviar.textContent = 'Salvar alteração';
    campoNome.focus();
}


//apagar avaliacao
async function excluirAvaliacao(id) {
    if (!confirm('Deseja realmente excluir esta avaliação?')) {
        return;
    }

    const resposta = await fetch('crud/delete_avaliacao.php?id=' + id);
    const json = await resposta.json();

    alert(json.mensagem);

    if (idEmEdicao === id) {
        limparFormulario();
    }

    carregarAvaliacoes();
}


//limpa tudo e reseta o form
function limparFormulario() {
    campoNome.value = '';
    campoDescricao.value = '';
    campoNota.value = '';
    idEmEdicao = null;
    btnEnviar.textContent = 'Enviar';
}
