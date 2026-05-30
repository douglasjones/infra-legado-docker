<script>
//pega a largura da resolução da tela
var width = screen.width;
//pega a altura da resolução da tela
var height = screen.height;

//verifica se a resolução dará uma boa visão do site
if (width <= 800 || height <= 600)
alert("A resolução da tela do seu monitor é " + width + "x" + height + ". Para visualizar o site é recomendado uma resolução de no mínimo 1024x768.");
else
alert("A resolução da tela do seu monitor é " + width + "x" + height + ".");
</script>