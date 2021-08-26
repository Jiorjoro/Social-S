


// define a altura do rodapé
function setRodape(){
	const bodyLen = document.body.scrollHeight;
	const rodape = document.getElementById('rodape');
	if(window.innerHeight < bodyLen){
		rodape.style.top = 200 + 'px';
	} else if(window.innerHeight > bodyLen){
		rodape.style.top = window.innerHeight - bodyLen + 100 + 'px';
	}
}

// botão 'back-to-top'
function scrollToTop() {
  let scrollToTopBtn = document.getElementById("scrollToTopBtn")
  let rootElement = document.documentElement

  // Scroll to top logic
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth"
  })
}

//teste de mudar o input
function inputTransfer() {
  document.getElementById('inputTextarea').value = document.getElementById('digitarTextoPub').value;
}

