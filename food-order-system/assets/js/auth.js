document.addEventListener("DOMContentLoaded", () => {
    
    // --- LOGIN TABS ---
    const userTab = document.getElementById("userTab");
    const adminTab = document.getElementById("adminTab");
    const loginTitle = document.getElementById("loginTitle");
    const loginDesc = document.getElementById("loginDesc");
    let isAdminLogin = false;

    if (userTab && adminTab) {
        userTab.addEventListener("click", () => {
            userTab.classList.add("active");
            adminTab.classList.remove("active");
            loginTitle.textContent = "Ingia Mfumboni";
            loginDesc.textContent = "Weka taarifa zako ili kuagiza chakula";
            isAdminLogin = false;
        });

        adminTab.addEventListener("click", () => {
            adminTab.classList.add("active");
            userTab.classList.remove("active");
            loginTitle.textContent = "Ingia kwa Msimamizi";
            loginDesc.textContent = "Weka taarifa zako za msimamizi";
            isAdminLogin = true;
        });
    }
    
    // --- 1. LOGIC YA KUJISAJILI ---
    const regForm = document.getElementById("registerForm");
    if (regForm) {
        regForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = {
                fullname: document.getElementById("fullname").value,
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            };

            try {
                const response = await fetch("api/register_api.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(formData)
                });
                const result = await response.json();
                alert(result.message);
                if (result.success) window.location.href = "login.html";
            } catch (error) {
                alert("Tatizo la mawasiliano.");
            }
        });
    }

    // --- 2. LOGIC YA KUINGIA (LOGIN) ---
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = {
                email: document.getElementById("email").value,
                password: document.getElementById("password").value
            };

            try {
                const response = await fetch("api/login_api.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(formData)
                });
                if (!response.ok) {
                    throw new Error(`Server responded with status: ${response.status}`);
                }
                const result = await response.json();

                if (result.success) {
                    // MUHIMU: Hifadhi taarifa za user kwenye browser
                    localStorage.setItem("userRole", result.role);
                    localStorage.setItem("userName", result.fullname);
                    
                    alert(result.message);
                    
                    // Elekeza kulingana na Role
                    if (result.role === 'admin') {
                        window.location.href = "admin_dashboard.php";
                    } else {
                        window.location.href = "index.php";
                    }
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error("Login error:", error);
                alert("Imeshindwa kuwasiliana na server. Hakikisha Apache na MySQL zinaendeshwa katika XAMPP.");
            }
        });
    }
});