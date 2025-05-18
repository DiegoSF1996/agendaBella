import Ionicons from '@expo/vector-icons/Ionicons';
import { router } from 'expo-router';
import React from 'react';
import { View, Text, FlatList, StyleSheet, TouchableOpacity } from 'react-native';

const agendamentos = [
  {
    id: '1',
    data: '2023-10-01',
    hora: '10:00',
    cliente: {
      nome:'João Silva',
      telefone: '123456789',
      nota: '4.5',
    },
    servico: 'Corte de cabelo',
    preco: 'R$ 50,00',
  },
  {
    id: '2',
    data: '2023-09-15',
    hora: '14:30',
    cliente: {
      nome:'Maria Souza',
      telefone: '987654321',
      nota: '4.8',
    },
    servico: 'Manicure',
    preco: 'R$ 80,00',
  },
];

export default function listarAtendimentosScreen() {
  return (
    <View style={styles.container}>
      
      <Text style={styles.title}>Estabelecimentos</Text>
      <FlatList
        data={agendamentos}
        keyExtractor={(item) => item.id}
        renderItem={({ item }) => (
          <View style={styles.card}>
            <View style={styles.cardInfo}>
              <Text style={styles.info}>
                <Text style={styles.label}>Data: </Text>{item.data}
              </Text>
              <Text style={styles.info}>
                <Text style={styles.label}>Hora: </Text>{item.hora}
              </Text>
              <Text style={styles.info}>
                <Text style={styles.label}>Cliente: </Text>{item.cliente.nome}
              </Text>
            </View>
            <TouchableOpacity
              style={styles.button}
            >
              <Ionicons name="calendar-outline" size={18} color="#fff" style={{ marginRight: 6 }} />
              <Text style={styles.buttonText}>Atender</Text>
            </TouchableOpacity>
          </View>
        )}
        contentContainerStyle={{ paddingBottom: 30 }}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    paddingHorizontal: 16,
    paddingTop: 24,
  },
  title: {
    fontSize: 26,
    fontWeight: 'bold',
    color: '#ff65b5',
    marginBottom: 16,
    textAlign: 'center',
  },
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
  cardInfo: {
    marginBottom: 12,
  },
  info: {
    fontSize: 16,
    marginBottom: 4,
    color: '#333',
  },
  label: {
    fontWeight: '600',
    color: '#555',
  },
  button: {
    flexDirection: 'row',
    backgroundColor: '#ff65b5',
    paddingVertical: 10,
    paddingHorizontal: 16,
    borderRadius: 8,
    alignSelf: 'flex-start',
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontWeight: '600',
    fontSize: 15,
  },
  backButton: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 15,
  },
  backText: {
    fontSize: 16,
    marginLeft: 5,
    color: '#ff65b5',
    fontWeight: '600',
  },
});

