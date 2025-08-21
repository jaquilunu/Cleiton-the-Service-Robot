document.addEventListener("DOMContentLoaded", function () {
    const fecharButton = document.querySelector("#fechar");

    fecharButton.addEventListener("click", function () {
        if (confirm("Deseja realmente fechar esta janela?")) {
            window.close();
        }
    });

    const salvarButton = document.querySelector("#salvar");

    salvarButton.addEventListener("click", function () {
        alert("Dados salvos com sucesso!");
    });

    const novoButton = document.querySelector("#novo");

    novoButton.addEventListener("click", function () {
        document.querySelectorAll("input").forEach(input => {
            input.value = "";
        });
        alert("Campos limpos para novo cadastro!");
    });

    const excluirButton = document.querySelector("#excluir");

    excluirButton.addEventListener("click", function () {
        if (confirm("Deseja realmente excluir os dados?")) {
            document.querySelectorAll("input").forEach(input => {
                input.value = "";
            });
            alert("Dados excluídos com sucesso!");
        }
    });
});
