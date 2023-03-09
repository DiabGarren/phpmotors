'use strict'

// Get a list of vehicles in inventory based on the classificationId
let classificationList = document.querySelector("#classificationList");
classificationList.addEventListener("change", () => {
    let classificationId = classificationList.value;
    let classIdURL = `/phpmotors/vehicles/?action=getInventoryItems&classificationId=${classificationId}`;
    fetch(classIdURL)
        .then((response) => {
            if (response.ok) {
                return response.json();
            }
            throw Error("Network response failed");
        })
        .then((data) => {
            buildInventoryList(data);

        })
        .catch((error) => {
            console.log("There was a problem: ", error.message);
        })
});

// Build inventory items into HTML table components and inject into DOM
function buildInventoryList(data) {
    let inventoryDisplay = document.querySelector("#inventoryDisplay");
    if (data.length){
        // Set up the table labels
        let dataTable = "<thead>";
        dataTable += "<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>";
        dataTable += "</thead>";
    
        // Set up the table body
        dataTable += "<tbody>";
        // Iterate over all vehicles in the array and put each in a row
        data.forEach((element) => {
            dataTable += `<tr><td>${element.invMake} ${element.invModel}</td>`;
            dataTable += `<td><a href="/phpmotors/vehicles?action=mod&invId=${element.invId}" title="Click to modify">Modify</a></td>`;
            dataTable += `<td><a href="/phpmotors/vehicles?action=del&invId=${element.invId}" title="Click to delete">Delete</a></td></tr>`;
        });
        dataTable += "</tbody>";
        // Display the contents in the Vehicle Management View
        inventoryDisplay.innerHTML = dataTable;
    } else {
        inventoryDisplay.innerHTML = '';
    }
}