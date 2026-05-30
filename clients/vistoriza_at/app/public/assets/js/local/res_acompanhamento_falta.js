function fcCancelar(){
    var objParametros = {};
    sendPost('relatorio','pesqAcompanhamentoFalta' ,objParametros);
}

function textoRelatorioFalta(selector) {
    return $.trim($(selector).val() || "");
}

function nomeArquivoRelatorioFalta(extensao) {
    var mes = textoRelatorioFalta("#ds_mes") || "mes";
    var ano = textoRelatorioFalta("#ds_ano") || "ano";
    return "relatorio-acompanhamento-falta-" + mes + "-" + ano + "." + extensao;
}

function exportarExcelAcompanhamentoFalta() {
    var tabela = $("#tblResultado").clone();

    tabela.find("thead th, tbody td").each(function () {
        $(this).attr("style", "border:1px solid #d9d9d9;padding:6px;mso-number-format:'\\@';");
    });
    tabela.find("thead th").attr("style", "border:1px solid #d9d9d9;padding:6px;background:#f2f2f2;font-weight:bold;mso-number-format:'\\@';");

    var html = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
              xmlns:x="urn:schemas-microsoft-com:office:excel"
              xmlns="http://www.w3.org/TR/REC-html40">
            <head>
                <meta charset="UTF-8">
                <!--[if gte mso 9]>
                <xml>
                    <x:ExcelWorkbook>
                        <x:ExcelWorksheets>
                            <x:ExcelWorksheet>
                                <x:Name>Faltas</x:Name>
                                <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
                            </x:ExcelWorksheet>
                        </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                </xml>
                <![endif]-->
            </head>
            <body>
                <table>
                    <tr><td colspan="7"><strong>Relatório Acompanhamento Falta</strong></td></tr>
                    <tr><td><strong>Colaborador:</strong></td><td colspan="6">${textoRelatorioFalta("#ds_colaboradores")}</td></tr>
                    <tr><td><strong>Posto de trabalho:</strong></td><td colspan="6">${textoRelatorioFalta("#ds_lead")}</td></tr>
                    <tr><td><strong>Mês:</strong></td><td>${textoRelatorioFalta("#ds_mes")}</td><td><strong>Ano:</strong></td><td>${textoRelatorioFalta("#ds_ano")}</td></tr>
                    <tr><td><strong>Apontamento:</strong></td><td colspan="6">${textoRelatorioFalta("#ds_apontamento")}</td></tr>
                    <tr><td colspan="7">&nbsp;</td></tr>
                </table>
                ${tabela.prop("outerHTML")}
            </body>
        </html>
    `;

    var blob = new Blob(["\ufeff", html], { type: "application/vnd.ms-excel;charset=utf-8" });
    var link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = nomeArquivoRelatorioFalta("xls");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(link.href);
}

$(document).ready(function () {
    $(document).on('click', '#cmdCancelar', fcCancelar);

    $('#tblResultado').DataTable({
        scrollX: true,  // Desabilite o scrollX
        responsive: true,
        searching: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'Exportar PDF',
                title: 'Relatório Acompanhamento Falta - ' + $("#ds_mes").val() + "-" + $("#ds_ano").val(),
                orientation: 'landscape',
                pageSize: 'A1',
                exportOptions: {
                    columns: ':visible'
                },
                customize: function (doc) {
                    doc.styles.title = {
                        fontSize: 14,
                        bold: true,
                        alignment: 'center'
                    };
                    doc.styles.tableHeader = {
                        bold: true,
                        fontSize: 12,
                        color: 'white',
                        fillColor: '#4CAF50',
                        alignment: 'center'
                    };
                    
                    // Ajuste para 7 colunas
                    doc.content[1].table.widths = ['14%', '14%', '14%', '14%', '14%', '14%', '16%'];
    
                    doc.pageMargins = [20, 20, 20, 20];
                    doc.defaultStyle.fontSize = 10;
    
                    var rowCount = doc.content[1].table.body.length;
                    for (var i = 1; i < rowCount; i++) {
                        doc.content[1].table.body[i].forEach(function(cell) {
                            cell.alignment = 'center';
                            cell.margin = [2, 2, 2, 2];
                        });
                    }
                }
            },
            {
                text: 'Exportar Excel',
                action: function () {
                    exportarExcelAcompanhamentoFalta();
                }
            }
        ],
        language: {
            "sProcessing": "Processando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primeiro",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "ordering": false,
        "paging":false
    });
    
    

});

