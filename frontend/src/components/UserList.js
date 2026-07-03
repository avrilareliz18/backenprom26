import {api} from '../utils/api';

export const getUserList = async () => {
    const container = document = document.getElementById('usersTablet')
    container.innerHTML = '<tr><td>Cargando...</td></tr>'; //limpiar el contenido existente de la tabla
    try {
        const users = await api.get('/users');
        container.innerHTML = users.map(user =>`
            <tr> 
            <td>${user.id}</td>
            <td>${user.nombre}</td>
            <td>${user.apellido}</td>
            <td>${user.passwor}</td>
        </tr>
      `).join('');
    } catch (error) {
        container.innerHTML = '<tr><td> colspan="5">Error al cargar la lista de usuarios</td></tr>';
    }
}