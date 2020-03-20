<p> A proposta desse sistema é o envio de emails com um pdf em anexo periodicamente, sendo uma extensão de um ERP desktop <p>

<p> Para funcionar será necessario configurar o task schedule no crontab do linux (vide documentação do laravel).</p>

<p> As duas funções principais estão no EmailsController, onde uma irá checar uma pasta no servidor, onde será feito upload dos arquivos, e irá tratá-los pelo nome específico para integração, inserí-lo no banco de dados e copiar para a pasta de espera.</p>
<p> A próxima função irá de fato enviar o email. O cron está configurado para enviar o email a cada 1 minuto e a cada 5 será verificado a pasta para novos emails. <p>
