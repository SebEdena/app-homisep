let tablinks = document.getElementsByClassName("tablink");
let tabcontainers = document.getElementsByClassName("tabcontainer");

for(let i = 0; i < tablinks.length; i++){
	tablinks[i].onclick = function(){ openTab(this); }
}

function openTab(elt){
	let tabs = elt.parentNode.children;
	let tab_pages = elt.parentNode.parentNode
					   .getElementsByClassName("tabcontent")[0].children;
    if(tab_pages.length !== tabs.length){
		console.error("Not the same number of tabs and tabs pages.");
	}
	for(let i = 0; i < tabs.length; i++){
        let j = (i >= tab_pages.length)?(tab_pages.length - 1):i;
		tab_pages[j].style.display = "none";
		if(tabs[i].classList.contains("active")){
			tabs[i].classList.remove("active");
		}
	}
	for(let i = 0; i < tabs.length; i++){
		if(tabs[i] === elt){
			let j = (i >= tab_pages.length)?(tab_pages.length - 1):i;
			tab_pages[j].style.display = "block";
			tabs[i].classList.add("active");
		}
	}
}

for(let i = 0; i < tabcontainers.length; i++){
	tabcontainers[i].querySelector("#defaultOpen").click();
}
