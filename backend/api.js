const API_URL = "http://localhost/CMS/backend/";

export const authFetch = (endpoint, options = {}) => {
  const token = localStorage.getItem("token");

  return fetch(API_URL + endpoint, {
    ...options,
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
      ...options.headers,
    },
  });
};
