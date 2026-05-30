<?
// exemplo1.php
// fazer uso da classe jpgraph padrão e sua especialização
// em gráfico de barras
include ("grafico/jpgraph.php");
include ("grafico/jpgraph_bar.php");

/*
Definir um array para cada ponto da coordenada Y, especificando
seus pontos/valores, sendo:
$numGols = o número de gols marcados em cada dia da semana, 
começando Domingo (8 gols) e terminando Sábado (11 gols)
*/ 
$numGols = array ("1", "5", "2", "2", "2", "2", "5");

// iniciar criação do gráfico
$grafico = new graph(350,200,"png");

// ajustar alguns parâmetros
$grafico->SetScale("textlin");
$grafico->SetShadow();

$grafico->title->Set('GEPROS');

// criar o gráfico de barras
$gBarras = new BarPlot($numGols);

// ajuste de cores
$gBarras->SetFillColor("gray");
$gBarras->SetShadow("darkblue");

// adicionar gráfico de barras ao gráfico
$grafico->Add($gBarras);

// imprimir gráfico
$grafico->Stroke();

?>