import Ionicons from '@expo/vector-icons/Ionicons';
import { router } from 'expo-router';
import React, { useState } from 'react';
import { View, Text, FlatList, StyleSheet, TouchableOpacity, Modal, Button } from 'react-native';

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
    nota_atribuida_ao_cliente: '4.8',
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
    nota_atribuida_ao_cliente: null,
  },
];

export default function historicoAtendimentosScreen() {
  const [modalVisible, setModalVisible] = useState(false);
  const [selectedCliente, setSelectedCliente] = useState(null);

  const handleAtribuirNota = (cliente) => {
    setSelectedCliente(cliente);
    setModalVisible(true);
  };

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
                <Text style={styles.label}>Preço: </Text>{item.preco}
              </Text>
              <Text style={styles.info}>
                <Text style={styles.label}>Cliente: </Text>{item.cliente.nome}
              </Text>
              <Text style={styles.info}>
                <Text style={styles.label}>Nota: </Text>{item.cliente.nota}/5
              </Text>
              {item.nota_atribuida_ao_cliente !== null && (
                <Text style={styles.info}>
                  <Text style={styles.label}>Nota atribuída: </Text>{item.nota_atribuida_ao_cliente}/5
                </Text>
              )}
            </View>
            <TouchableOpacity
              style={[styles.button, item.nota_atribuida_ao_cliente !== null ? styles.buttonDisabled : null]}
              onPress={() => handleAtribuirNota(item.cliente)}
              disabled={item.nota_atribuida_ao_cliente !== null}
            >
              <Ionicons name="calendar-outline" size={18} color="#fff" style={{ marginRight: 6 }} />
              <Text style={styles.buttonText}>Atribuir Nota</Text>
              {item.nota_atribuida_ao_cliente !== null && (
                <Text style={styles.buttonFeedback}>Nota já atribuída</Text>
              )}
            </TouchableOpacity>
          </View>
        )}
        contentContainerStyle={{ paddingBottom: 30 }}
      />

      <Modal
        animationType="slide"
        transparent={true}
        visible={modalVisible}
        onRequestClose={() => setModalVisible(false)}
      >
        <View style={styles.modalContainer}>
          <View style={styles.modalContent}>
            <Text style={styles.modalText}>Qual nota de 1 a 5 você gostaria de dar para {selectedCliente?.nome}?</Text>
            <View style={styles.modalButtons}>
              {[1, 2, 3, 4, 5].map((nota) => (
                <Button key={nota} title={nota.toString()} onPress={() => {
                  alert(`Nota ${nota} atribuída a ${selectedCliente?.nome}`);
                  setModalVisible(false);
                }} />
              ))}
            </View>
            <Button title="Cancelar" onPress={() => setModalVisible(false)} />
          </View>
        </View>
      </Modal>
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
  buttonDisabled: {
    backgroundColor: '#f5f5f5',
    color: '#666',
  },
  buttonFeedback: {
    fontSize: 12,
    color: '#666',
    marginLeft: 8,
  },
  buttonText: {
    color: '#fff',
    fontWeight: '600',
    fontSize: 15,
  },
  modalContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
  },
  modalContent: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 20,
    alignItems: 'center',
  },
  modalText: {
    fontSize: 18,
    marginBottom: 20,
    textAlign: 'center',
  },
  modalButtons: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    width: '100%',
    marginBottom: 20,
  },
});

