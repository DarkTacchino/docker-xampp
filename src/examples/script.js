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

//da base
async function fetchDataDB() {
    const url = "../api/users.php";
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
    const i = 0;
    if(i == 1)
    {
        const dat = await fetchData();
    }
    else
    {
        const dat = await fetchDataDB();
    }
    
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
document.getElementById("load-data-button-db").addEventListener('click', populateTable);
