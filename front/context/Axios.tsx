import axios from 'axios';
import Constants from './Constants';
const api = axios.create({
    baseURL: Constants.expo.api_url, // Troque pela URL da sua API
    headers: {
        'Content-Type': 'application/json',
    },
});

// Adicione aqui o token, se necessário
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default {
    // USERS
    getUsers: async () => await api.get('/users').then(),
    getUser: async (id: number) => await api.get(`/users/${id}`).then(),
    createUser: async (data: any) => await api.post('/users', data).then(),
    updateUser: async (id: number, data: any) => await api.put(`/users/${id}`, data).then(),
    deleteUser: async (id: number) => await api.delete(`/users/${id}`).then(),

    // SERVIÇOS
    getServicos: async () => await api.get('/servicos'),
    getServico: async (id: number) => await api.get(`/servicos/${id}`).then(),
    createServico: async (data: any) => await api.post('/servicos', data).then(),
    updateServico: async (id: number, data: any) => await api.put(`/servicos/${id}`, data).then(),
    deleteServico: async (id: number) => await api.delete(`/servicos/${id}`).then(),

    // PESSOA FÍSICA
    getPessoaFisicas: async () => await api.get('/pessoa-fisicas').then(),
    getPessoaFisica: async (id: number) => await api.get(`/pessoa-fisicas/${id}`).then(),
    createPessoaFisica: async (data: any) => await api.post('/pessoa-fisicas', data).then(),
    updatePessoaFisica: async (id: number, data: any) => await api.put(`/pessoa-fisicas/${id}`, data).then(),
    deletePessoaFisica: async (id: number) => await api.delete(`/pessoa-fisicas/${id}`).then(),

    // PESSOA JURÍDICA
    getPessoaJuridicas: async () => await api.get('/pessoa-juridicas').then(),
    getPessoaJuridica: async (id: number) => await api.get(`/pessoa-juridicas/${id}`).then(),
    createPessoaJuridica: async (data: any) => await api.post('/pessoa-juridicas', data).then(),
    updatePessoaJuridica: async (id: number, data: any) => await api.put(`/pessoa-juridicas/${id}`, data).then(),
    deletePessoaJuridica: async (id: number) => await api.delete(`/pessoa-juridicas/${id}`).then(),

    // STATUS AGENDAMENTO
    getStatusAgendamentos: async () => await api.get('/status-agendamentos').then(),
    getStatusAgendamento: async (id: number) => await api.get(`/status-agendamentos/${id}`).then(),
    createStatusAgendamento: async (data: any) => await api.post('/status-agendamentos', data).then(),
    updateStatusAgendamento: async (id: number, data: any) => await api.put(`/status-agendamentos/${id}`, data).then(),
    deleteStatusAgendamento: async (id: number) => await api.delete(`/status-agendamentos/${id}`).then(),

    // AGENDAMENTOS
    getAgendamentos: async () => await api.get('/agendamentos').then(),
    getAgendamento: async (id: number) => await api.get(`/agendamentos/${id}`).then(),
    createAgendamento: async (data: any) => await api.post('/agendamentos', data).then(),
    updateAgendamento: async (id: number, data: any) => await api.put(`/agendamentos/${id}`, data).then(),
    deleteAgendamento: async (id: number) => await api.delete(`/agendamentos/${id}`).then(),

    obterVagasDisponiveis: async () => await api.get('/agendamentos/obter-vagas-disponiveis').then(),
    agendarPessoaFisica: async (agendamento_id: number, data: any) => await api.put(`/agendamentos/${agendamento_id}/agendar-pessoa-fisica`, data).then(),
    desativarAgendamento: async (data: any) => await api.post('/agendamentos/desativar-agendamento', data).then(),
    gerarAgendaServicoMensal: async (data: any) => await api.post('/agendamentos/gerar-agenda-servico-mensal', data).then(),

    // AVALIAÇÃO AGENDAMENTOS
    getAvaliacaoAgendamentos: async () => await api.get('/avaliacao-agendamentos').then(),
    getAvaliacaoAgendamento: async (id: number) => await api.get(`/avaliacao-agendamentos/${id}`).then(),
    createAvaliacaoAgendamento: async (data: any) => await api.post('/avaliacao-agendamentos', data).then(),
    updateAvaliacaoAgendamento: async (id: number, data: any) => await api.put(`/avaliacao-agendamentos/${id}`, data).then(),
    deleteAvaliacaoAgendamento: async (id: number) => await api.delete(`/avaliacao-agendamentos/${id}`).then(),

    // PESSOA JURÍDICA SERVIÇOS
    getPessoaJuridicaServicos: async () => await api.get('/pessoa-juridica-servicos').then(),
    getPessoaJuridicaServico: async (id: number) => await api.get(`/pessoa-juridica-servicos/${id}`).then(),
    createPessoaJuridicaServico: async (data: any) => await api.post('/pessoa-juridica-servicos', data).then(),
    updatePessoaJuridicaServico: async (id: number, data: any) => await api.put(`/pessoa-juridica-servicos/${id}`, data).then(),
    deletePessoaJuridicaServico: async (id: number) => await api.delete(`/pessoa-juridica-servicos/${id}`).then(),

    // SERVIÇO HORÁRIOS
    getServicoHorarios: async () => await api.get('/servico-horarios').then(),
    getServicoHorario: async (id: number) => await api.get(`/servico-horarios/${id}`).then(),
    createServicoHorario: async (data: any) => await api.post('/servico-horarios', data).then(),
    updateServicoHorario: async (id: number, data: any) => await api.put(`/servico-horarios/${id}`, data).then(),
    deleteServicoHorario: async (id: number) => await api.delete(`/servico-horarios/${id}`).then(),
};
