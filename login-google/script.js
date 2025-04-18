const CLIENT_ID = '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';

window.onload = () => {
  google.accounts.id.initialize({
    client_id: CLIENT_ID,
    callback: handleCredentialResponse,
  });

  google.accounts.id.renderButton(
    document.getElementById('g_id_signin'),
    { theme: 'outline', size: 'large' }
  );

  google.accounts.id.prompt();
};

/**
 * Callback de sucesso no login
 * @param {Object} response
 */
function handleCredentialResponse(response) {
  const jwt = response.credential;
  const user = parseJwt(jwt);

  const info = document.getElementById('user-info');
  info.innerHTML = `
    <p>Bem‑vindo, <strong>${user.name}</strong></p>
    <img src="${user.picture}" alt="Foto de perfil" />
  `;
  info.classList.remove('hidden');
}

/**
 * @param {string} token
 * @returns {Object}
 */

function parseJwt(token) {
  const base64Url = token.split('.')[1];
  const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  const jsonPayload = decodeURIComponent(
    atob(base64)
      .split('')
      .map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
      .join('')
  );
  return JSON.parse(jsonPayload);
}
