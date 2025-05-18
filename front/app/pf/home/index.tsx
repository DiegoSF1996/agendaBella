import Ionicons from '@expo/vector-icons/Ionicons';
import { router } from 'expo-router';
import React from 'react';
import { View, Text, FlatList, StyleSheet, TouchableOpacity } from 'react-native';

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
      <Text style={styles.title}>Meus Agendamentos</Text>

      <FlatList
        data={agendamentos}
        keyExtractor={item => item.id}
        renderItem={({ item }) => (
          <View style={styles.card}>
            <View style={styles.header}>
              <Text style={styles.data}>{item.data} às {item.horario}</Text>
              <TouchableOpacity onPress={() => alert('Entrar na videochamada')}>
                <Ionicons name="eye-outline" size={24} color="#ff65b5" />
              </TouchableOpacity>
            </View>

            <Text style={styles.info}>
              <Text style={styles.label}>Empresa: </Text>{item.empresa}
            </Text>
            <Text style={styles.info}>
              <Text style={styles.label}>Local: </Text>{item.local}
            </Text>
            <Text style={styles.info}>
              <Text style={styles.label}>Serviço: </Text>{item.tipoServico}
            </Text>

            <Text style={[
              styles.status,
              item.status === 'pendente' ? styles.pendente : styles.executado
            ]}>
              {item.status === 'pendente' ? 'Pendente' : 'Executado'}
            </Text>
          </View>
        )}
        contentContainerStyle={{ paddingBottom: 80 }}
      />

      <TouchableOpacity
        style={styles.fab}
        onPress={() => router.push('pf/agendar')}
      >
        <Ionicons name="add" size={30} color="#fff" />
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#fff', padding: 20 },
  title: { fontSize: 26, fontWeight: 'bold', color: '#ff65b5', textAlign: 'center', marginBottom: 16 },
  card: {
    backgroundColor: '#fff0f5',
    borderRadius: 12,
    padding: 16,
    marginBottom: 16,
    shadowColor: '#000',
    shadowOpacity: 0.05,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 8,
    elevation: 3,
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 10,
  },
  data: {
    fontSize: 16,
    fontWeight: '600',
    color: '#ff65b5',
  },
  info: {
    fontSize: 15,
    marginBottom: 4,
    color: '#333',
  },
  label: {
    fontWeight: '600',
    color: '#555',
  },
  status: {
    marginTop: 10,
    paddingVertical: 6,
    paddingHorizontal: 12,
    borderRadius: 20,
    alignSelf: 'flex-start',
    fontSize: 14,
    fontWeight: 'bold',
    color: '#fff',
  },
  pendente: { backgroundColor: '#ff9f43' },
  executado: { backgroundColor: '#28c76f' },

  fab: {
    position: 'absolute',
    bottom: 24,
    right: 24,
    backgroundColor: '#ff65b5',
    width: 60,
    height: 60,
    borderRadius: 30,
    alignItems: 'center',
    justifyContent: 'center',
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowOffset: { width: 0, height: 4 },
    shadowRadius: 8,
    elevation: 6,
  },
});
