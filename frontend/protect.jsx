const token = localStorage.getItem("token");

fetch("http://localhost/CMS/backend/protect.php", {
  headers: {
    Authorization: `Bearer ${token}`
  }
});
