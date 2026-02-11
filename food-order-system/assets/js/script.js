document.addEventListener("DOMContentLoaded", () => {
    const menuContainer = document.getElementById("menu-container");
    const searchBar = document.getElementById("searchBar");
    let allMenuItems = [];
    let cart = [];

    // Logout functionality
    const logoutBtn = document.getElementById("logoutBtn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", logoutUser);
    }

    // 2. Pakia Vyakula kutoka Database
    async function fetchMenu() {
        try {
            const response = await fetch("api/get_menu.php");
            const result = await response.json();

            if (result.success) {
                allMenuItems = result.data;
                displayMenu(allMenuItems);
            } else {
                menuContainer.innerHTML = `<p>${result.message}</p>`;
            }
        } catch (error) {
            menuContainer.innerHTML = "<p>Hitilafu ya kuunganisha na server.</p>";
        }
    }

    function displayMenu(items) {
        menuContainer.innerHTML = items.map(item => `
            <div class="food-card">
                <img src="assets/images/${item.image_url || 'default.jpg'}" alt="${item.item_name}">
                <div class="food-info">
                    <h3>${item.item_name}</h3>
                    <p>${item.description}</p>
                    <span class="price">TSh ${parseFloat(item.price).toLocaleString()}</span>
                    <button class="order-btn" onclick="processOrder(${item.item_id}, ${item.price}, '${item.item_name}')">Agiza Sasa</button>
                </div>
            </div>
        `).join('');
    }

    // 3. Search Logic
    searchBar.addEventListener("input", (e) => {
        const term = e.target.value.toLowerCase();
        const filtered = allMenuItems.filter(i => i.item_name.toLowerCase().includes(term));
        displayMenu(filtered);
    });

    fetchMenu();
});

// 4. Kutuma Oda (Mawasiliano na API)
async function processOrder(id, price, name) {
    const userRole = localStorage.getItem("userRole");
    if (!userRole) {
        alert("Tafadhali ingia (Login) kwanza ili uagize!");
        // Since login is on the same page, no redirect needed
        return;
    }

    if (confirm(`Je, unathibitisha kuagiza ${name} kwa TSh ${price}?`)) {
        try {
            const response = await fetch("api/place_order.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    items: [{ id: id, price: price, qty: 1 }],
                    total: price
                })
            });
            const result = await response.json();
            alert(result.message);
        } catch (error) {
            alert("Oda imeshindwa kutumwa.");
        }
    }
}

function logoutUser() {
    localStorage.clear();
    window.location.href = "api/logout.php";
}