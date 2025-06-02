const CLIENT_ID = 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com';

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

  document.getElementById('logout-btn').addEventListener('click', logout);
};

function handleCredentialResponse(response) {
  const jwt = response.credential;
  const user = parseJwt(jwt);

  const info = document.getElementById('user-info');
  info.innerHTML = `
    <p>Bem‑vindo, <strong>${user.name}</strong></p>
    <img src="${user.picture}" alt="Foto de perfil" />
  `;
  info.classList.remove('hidden');

  document.getElementById('g_id_signin').classList.add('hidden');
  document.getElementById('login-title').classList.add('hidden');
  document.getElementById('logout-btn').classList.remove('hidden');
  document.getElementById('logout-btn').classList.remove('hidden');
  mostrarCrud();
}

function logout() {
  document.getElementById('user-info').classList.add('hidden');
  document.getElementById('user-info').innerHTML = '';
  document.getElementById('g_id_signin').classList.remove('hidden');
  document.getElementById('login-title').classList.remove('hidden');
  document.getElementById('logout-btn').classList.add('hidden');
  esconderCrud(); // ⬅️ Adicionado

}


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

function mostrarCrud() {
  document.getElementById('crud-container').classList.remove('hidden');
  listarClientes();
}

function esconderCrud() {
  document.getElementById('crud-container').classList.add('hidden');
  document.getElementById('clientes-list').innerHTML = '';
}

function listarClientes() {
  fetch('http://localhost:5202/api/v1/dadoscliente')
    .then(res => {
      if (!res.ok) throw new Error("Resposta inválida");
      return res.json();
    })
    .then(data => {
      const list = document.getElementById('clientes-list');
      list.innerHTML = '';
      data.forEach(cliente => {
        const item = document.createElement('li');
        item.textContent = `${cliente.nomeCliente} - ${cliente.emailCliente}`;
        list.appendChild(item);
      });
    })
    .catch(err => console.error('Erro ao buscar clientes:', err));
}


function adicionarCliente() {
  const nome = document.getElementById('nome').value;
  const email = document.getElementById('email').value;

  fetch('http://localhost:5202/api/v1/dadoscliente', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      nome: nome,
      telefone: "000000000",
      site: "https://exemplo.com",
      cores: JSON.stringify({ tema: "claro" }),
      logo: null,
      segmento: "Não informado",
      descricao: "Descrição de teste",
      publicoAlvo: "Geral",
      faixaPreco: "Variado",
      idUser: "google-login"
    })
  })
    .then(res => {
      if (res.ok) {
        listarClientes();
        document.getElementById('nome').value = '';
        document.getElementById('email').value = '';
      } else {
        alert('Erro ao adicionar cliente');
      }
    })
    .catch(err => console.error('Erro ao adicionar cliente:', err));
}


function excluirCliente(id) {
  fetch(`http://localhost:5202/api/v1/dadoscliente/${id}`, {
    method: 'DELETE'
  })
    .then(res => {
      if (res.ok) {
        listarClientes();
      } else {
        alert('Erro ao excluir cliente');
      }
    })
    .catch(err => console.error('Erro ao excluir cliente:', err));
}