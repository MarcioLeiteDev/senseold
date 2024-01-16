const { PDFDocument } = require('pdf-lib');
const fs = require('fs').promises;

// Seu array de dados
const dados = [
    ['Nome', 'Idade', 'Cidade'],
    ['João', 25, 'São Paulo'],
    ['Maria', 30, 'Rio de Janeiro'],
    ['José', 22, 'Belo Horizonte'],
];

async function gerarPDF() {
    // Crie um novo documento PDF
    const pdfDoc = await PDFDocument.create();
    const page = pdfDoc.addPage();

    // Defina a fonte e o tamanho do texto
    const font = await pdfDoc.embedFont(PDFDocument.Font.Helvetica);
    const textSize = 12;

    // Adicione os cabeçalhos
    for (let i = 0; i < dados[0].length; i++) {
        const cabecalho = dados[0][i];
        page.drawText(cabecalho, { x: i * 80 + 10, y: 700, font, size: textSize });
    }

    // Adicione os dados
    for (let i = 1; i < dados.length; i++) {
        for (let j = 0; j < dados[i].length; j++) {
            const valor = dados[i][j];
            page.drawText(valor.toString(), { x: j * 80 + 10, y: 700 - i * 20, font, size: textSize });
        }
    }

    // Salve o PDF em um arquivo
    const pdfBytes = await pdfDoc.save();
    await fs.writeFile('output.pdf', pdfBytes);
}

// Chame a função para gerar o PDF
gerarPDF().then(() => console.log('PDF gerado com sucesso!')).catch(error => console.error(error));
