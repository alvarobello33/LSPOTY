//Script per desplaçar la pàgina quan es fa una cerca

document.addEventListener('DOMContentLoaded', function() {

    //Busquem la secció de resultats de cerca del homepage
    const searchResults = document.getElementById('search-results');

    //Si hi ha resultats desplacem la finestra
    if (searchResults){
        searchResults.scrollIntoView({ behavior: 'smooth' });
    }
});