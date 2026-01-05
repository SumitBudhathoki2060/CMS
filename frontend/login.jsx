const login = async () => {
  const res = await fetch("http://localhost/CMS/backend/login.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      username,
      password
    })
  });

  const data = await res.json();

  if (data.token) {
    localStorage.setItem("token", data.token);
  }
};
