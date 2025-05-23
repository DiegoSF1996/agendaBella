import axios from 'axios';
import Constants from './Constants';
import { useAuth } from './AuthContext';


const api = axios.create({
    baseURL: Constants.expo.api_url, // Troque pela URL da sua API
    withCredentials: true,
    headers: {
        'Accept': 'application/json',  // ESSENCIAL
        'Content-Type': 'application/json', // só se o corpo for JSON
    }
});

// Adicione aqui o token, se necessário
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

api.interceptors.response.use(
    response => response, // Deixa as respostas com sucesso passarem
    error => {
        if (axios.isAxiosError(error)) {
            const status = error.response?.status;
            let message = 'Erro ao se comunicar com o servidor.';

            switch (status) {
                case 400: message = 'Requisição inválida. Verifique os dados enviados.'; break;
                case 401: message = 'Não autorizado. Faça login novamente.'; break;
                case 403: message = 'Acesso negado.'; break;
                case 404: message = 'Recurso não encontrado.'; break;
                case 406: message = 'Formato de dados não aceito pelo servidor.'; break;
                case 422: message = 'Erro de validação. Corrija os campos destacados.'; break;
                case 500: message = 'Erro interno no servidor. Tente novamente mais tarde.'; break;
            }

            // 🔔 Aqui você pode trocar por toast, modal, snackbar, etc.
            alert(message);
        } else {
            alert('Erro inesperado.');
        }
        return new Promise(() => { }); // ou return null
        //return Promise.reject(error); // Propaga o erro para quem chamou
    }
);

// 
export default {
    
    // USERS
    login: async (data: any) =>  await api.post('/users/login', data),
    getUsers: async () => await api.get('/users'),
    getUser: async (id: number) => await api.get(`/users/${id}`),
    createUser: async (data: any) => await api.post('/users', data),
    updateUser: async (id: number, data: any) => await api.put(`/users/${id}`, data),
    deleteUser: async (id: number) => await api.delete(`/users/${id}`),

    // SERVIÇOS
    getServicos: async () => await api.get('/servicos'),
    getServico: async (id: number) => await api.get(`/servicos/${id}`),
    createServico: async (data: any) => await api.post('/servicos', data),
    updateServico: async (id: number, data: any) => await api.put(`/servicos/${id}`, data),
    deleteServico: async (id: number) => await api.delete(`/servicos/${id}`),

    // PESSOA FÍSICA
    getPessoaFisicas: async () => await api.get('/pessoa-fisicas'),
    getPessoaFisica: async (id: number) => await api.get(`/pessoa-fisicas/${id}`),
    createPessoaFisica: async (data: any) => await api.post('/pessoa-fisicas', data),
    updatePessoaFisica: async (id: number, data: any) => await api.put(`/pessoa-fisicas/${id}`, data),
    deletePessoaFisica: async (id: number) => await api.delete(`/pessoa-fisicas/${id}`),

    // PESSOA JURÍDICA
    getPessoaJuridicas: async () => await api.get('/pessoa-juridicas'),
    getPessoaJuridica: async (id: number) => await api.get(`/pessoa-juridicas/${id}`),
    createPessoaJuridica: async (data: any) => await api.post('/pessoa-juridicas', data),
    updatePessoaJuridica: async (id: number, data: any) => await api.put(`/pessoa-juridicas/${id}`, data),
    deletePessoaJuridica: async (id: number) => await api.delete(`/pessoa-juridicas/${id}`),

    // STATUS AGENDAMENTO
    getStatusAgendamentos: async () => await api.get('/status-agendamentos'),
    getStatusAgendamento: async (id: number) => await api.get(`/status-agendamentos/${id}`),
    createStatusAgendamento: async (data: any) => await api.post('/status-agendamentos', data),
    updateStatusAgendamento: async (id: number, data: any) => await api.put(`/status-agendamentos/${id}`, data),
    deleteStatusAgendamento: async (id: number) => await api.delete(`/status-agendamentos/${id}`),

    // AGENDAMENTOS
    getAgendamentos: async () => await api.get('/agendamentos'),
    getAgendamento: async (id: number) => await api.get(`/agendamentos/${id}`),
    createAgendamento: async (data: any) => await api.post('/agendamentos', data),
    updateAgendamento: async (id: number, data: any) => await api.put(`/agendamentos/${id}`, data),
    deleteAgendamento: async (id: number) => await api.delete(`/agendamentos/${id}`),

    obterVagasDisponiveis: async () => await api.get('/agendamentos/obter-vagas-disponiveis'),
    agendarPessoaFisica: async (agendamento_id: number, data: any) => await api.put(`/agendamentos/${agendamento_id}/agendar-pessoa-fisica`, data),
    desativarAgendamento: async (data: any) => await api.post('/agendamentos/desativar-agendamento', data),
    gerarAgendaServicoMensal: async (data: any) => await api.post('/agendamentos/gerar-agenda-servico-mensal', data),

    // AVALIAÇÃO AGENDAMENTOS
    getAvaliacaoAgendamentos: async () => await api.get('/avaliacao-agendamentos'),
    getAvaliacaoAgendamento: async (id: number) => await api.get(`/avaliacao-agendamentos/${id}`),
    createAvaliacaoAgendamento: async (data: any) => await api.post('/avaliacao-agendamentos', data),
    updateAvaliacaoAgendamento: async (id: number, data: any) => await api.put(`/avaliacao-agendamentos/${id}`, data),
    deleteAvaliacaoAgendamento: async (id: number) => await api.delete(`/avaliacao-agendamentos/${id}`),

    // PESSOA JURÍDICA SERVIÇOS
    getPessoaJuridicaServicos: async () => await api.get('/pessoa-juridica-servicos'),
    getPessoaJuridicaServico: async (id: number) => await api.get(`/pessoa-juridica-servicos/${id}`),
    createPessoaJuridicaServico: async (data: any) => await api.post('/pessoa-juridica-servicos', data),
    updatePessoaJuridicaServico: async (id: number, data: any) => await api.put(`/pessoa-juridica-servicos/${id}`, data),
    deletePessoaJuridicaServico: async (id: number) => await api.delete(`/pessoa-juridica-servicos/${id}`),

    // SERVIÇO HORÁRIOS
    getServicoHorarios: async () => await api.get('/servico-horarios'),
    getServicoHorario: async (id: number) => await api.get(`/servico-horarios/${id}`),
    createServicoHorario: async (data: any) => await api.post('/servico-horarios', data),
    updateServicoHorario: async (id: number, data: any) => await api.put(`/servico-horarios/${id}`, data),
    deleteServicoHorario: async (id: number) => await api.delete(`/servico-horarios/${id}`),
};
