document.addEventListener("DOMContentLoaded", () => {
    const addFoodForm = document.getElementById("addFoodForm");
    const menuBody = document.getElementById("adminMenuBody");

    // 1. Kazi ya kuonyesha Menu (READ)
    async function loadMenu() {
        const response = await fetch("api/get_menu.php");
        const result = await response.json();
        if (result.success) {
            menuBody.innerHTML = result.data.map(item => `
                <tr>
                    <td><img src="assets/images/${item.image_url}" width="50"></td>
                    <td>${item.item_name}</td>
                    <td>TSh ${item.price}</td>
                    <td>
                        <button onclick="deleteItem(${item.item_id})" style="background:red; color:white; border:none; padding:5px; cursor:pointer;">Futa</button>
                    </td>
                </tr>
            `).join('');
        }
    }

    // 2. Kazi ya kuongeza Chakula (CREATE)
    if (addFoodForm) {
        addFoodForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const foodData = {
                name: document.getElementById("itemName").value,
                desc: document.getElementById("itemDesc").value,
                price: document.getElementById("itemPrice").value,
                image: document.getElementById("itemImage").value
            };

            const response = await fetch("api/add_food.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(foodData)
            });

            const result = await response.json();
            alert(result.message);
            if (result.success) {
                addFoodForm.reset();
                loadMenu(); // Refresh table
            }
        });
    }

    loadMenu();
});

// 3. Kazi ya kufuta (DELETE)
async function deleteItem(id) {
    if (confirm("Una uhakika unataka kufuta hiki chakula?")) {
        const response = await fetch(`api/delete_food.php?id=${id}`);
        const result = await response.json();
        alert(result.message);
        location.reload();
    }
}