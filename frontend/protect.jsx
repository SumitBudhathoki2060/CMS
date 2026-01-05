const token = localStorage.getItem("token");

fetch("http://localhost/api/protected.php", {
  headers: {
    Authorization: `Bearer ${token}`
  }
});
