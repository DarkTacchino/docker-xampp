async function fetchData() {
    const url = "../api/data.php";
    try {
        const response = await fetch(url);
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.error("Errore recupero dati:", error);
        return [];
    }
}

async function populateTable() {
    const dat = await fetchData();
    const data_table = document.getElementById("data-table");

    // Se 'dat' è un array, iteriamo direttamente su di esso
    dat.forEach(element => {
        const row = document.createElement('tr');
        const cell1 = document.createElement('td');
        const cell2 = document.createElement('td');
        const cell3 = document.createElement('td');
        cell1.textContent = element.nome;
        cell2.textContent = element.cognome;
        cell3.textContent = element.email;
        row.appendChild(cell1);
        row.appendChild(cell2);
        row.appendChild(cell3);
        data_table.appendChild(row);
    });
}

document.getElementById("load-data-button").addEventListener('click', populateTable);
