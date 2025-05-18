import React from 'react';
import { View, Text, FlatList, StyleSheet, TouchableOpacity } from 'react-native';
import Ionicons from '@expo/vector-icons/Ionicons';
const agendamentos = [
  {
    id: '1',
    data: '2025-05-20',
    horario: '14:30',
    empresa: 'Beleza e Estilo',
    local: 'Rua das Flores, 123',
    tipoServico: 'Corte de cabelo',
    status: 'pendente',
  },
  {
    id: '2',
    data: '2025-05-25',
    horario: '16:00',
    empresa: 'Relax & Spa',
    local: 'Praça Central, 10',
    tipoServico: 'Massagem',
    status: 'pendente',
  },
  {
    id: '3',
    data: '2025-05-15',
    horario: '09:00',
    empresa: 'Unhas & Cia',
    local: 'Av. Brasil, 456',
    tipoServico: 'Manicure',
    status: 'executado',
  }
];

export default function AgendamentosScreen() {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Histórico de atendimentos</Text>

      <FlatList
        data={agendamentos}
        keyExtractor={item => item.id}
        renderItem={({ item }) => (
          <View style={styles.card}>
            <TouchableOpacity style={styles.btn_ver_detalhes} onPress={() => alert('Entrar na videochamada')}>
              <Ionicons name="eye" size={32} color="#ffa3c6" />
            </TouchableOpacity>
            <Text style={styles.info}><Text style={styles.label}>Data:</Text> {item.data}</Text>
            <Text style={styles.info}><Text style={styles.label}>Horário:</Text> {item.horario}</Text>
            <Text style={styles.info}><Text style={styles.label}>Empresa:</Text> {item.empresa}</Text>
            <Text style={styles.info}><Text style={styles.label}>Local:</Text> {item.local}</Text>
            <Text style={styles.info}><Text style={styles.label}>Serviço:</Text> {item.tipoServico}</Text>
            <Text style={[
              styles.status,
              item.status === 'pendente' ? styles.pendente : styles.executado
            ]}>
              {item.status === 'pendente' ? 'Pendente' : 'Executado'}
            </Text>
          </View>
        )}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, padding: 20, backgroundColor: '#fff' },
  title: { fontSize: 24, fontWeight: 'bold', marginBottom: 20, color: '#ff65b5', textAlign: 'center' },
  card: {
    backgroundColor: '#fffbec',
    borderRadius: 10,
    padding: 15,
    marginBottom: 15,
    shadowColor: '#000',
    shadowOpacity: 0.05,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 4,
    elevation: 2,
  },
  info: { fontSize: 16, marginBottom: 5 },
  label: { fontWeight: 'bold' },
  status: {
    marginTop: 10,
    fontWeight: 'bold',
    padding: 8,
    borderRadius: 6,
    textAlign: 'center',
    color: '#fff',
    alignSelf: 'flex-start',
  },
  pendente: { backgroundColor: '#ff9f43' },
  executado: { backgroundColor: '#28c76f' },
  button: { backgroundColor: '#ff65b5', padding: 15, borderRadius: 8, alignSelf: 'flex-end' },
  buttonText: { color: '#fffbec', fontWeight: 'bold', fontSize: 16 },
  btn_ver_detalhes: { alignSelf: 'flex-end' },

});
