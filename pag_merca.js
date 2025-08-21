document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tabs li");
    const tabContent = document.querySelector(".tab-content");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            
            tabs.forEach(item => item.classList.remove("active"));

            tab.classList.add("active");

            switch (tab.textContent) {
                case "Descrição do Produto":
                    tabContent.innerHTML = `
                        <article>
                            <h3>Descrição Completa</h3>
                            <p>O biogás é uma alternativa sustentável para a reciclagem de plásticos, gerando energia limpa a partir de resíduos que, de outra forma, seriam descartados de maneira inadequada. A aplicação deste produto é ideal para indústrias que buscam reduzir a pegada ambiental.</p>
                        </article>`;
                    break;
                case "Características Técnicas":
                    tabContent.innerHTML = `
                        <article>
                            <h3>Características Técnicas</h3>
                            <ul>
                                <li>Material: Plástico reciclado</li>
                                <li>Volume: 500L</li>
                                <li>Energia gerada: 10 kWh</li>
                            </ul>
                        </article>`;
                    break;
                case "Avaliações":
                    tabContent.innerHTML = `
                        <article>
                            <h3>Avaliações dos Clientes</h3>
                            <div class="review">
                                <h4>Armando</h4>
                                <p>Vale o investimento. Produto de excelente qualidade e entrega rápida.</p>
                                <span>Nota: 5 estrelas</span>
                            </div>
                            <div class="review">
                                <h4>Anônimo</h4>
                                <p>Ótima qualidade e custo-benefício. Produto bastante resistente.</p>
                                <span>Nota: 4 estrelas</span>
                            </div>
                        </article>`;
                    break;
                default:
                    tabContent.innerHTML = "<p>Conteúdo não disponível.</p>";
            }
        });
    });
});document.addEventListener('DOMContentLoaded', function () {
    const emailButton = document.querySelector('.email-button');

    emailButton.addEventListener('click', function () {
        enviarNotaFiscalPorEmail();
    });
});
function enviarNotaFiscalPorEmail() {
    // Aqui seria implementada a lógica para envio por e-mail
    // Pode ser uma requisição HTTP para um backend ou serviço de e-mail
    alert('Nota fiscal enviada por e-mail com sucesso!');
}

