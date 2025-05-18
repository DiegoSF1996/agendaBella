import React, { useState } from 'react';
import { ScrollView, View, Text, FlatList, TouchableOpacity, StyleSheet } from 'react-native';
import { useAuth } from '@/context/AuthContext';
import { Ionicons } from '@expo/vector-icons';

export default function ServicosOferecidos() {
  const [selectedServices, setSelectedServices] = useState<string[]>([]);
  const { user } = useAuth();

  const services = [
    { id: '1', name: 'Corte de cabelo' },
    { id: '2', name: 'Manicure' },
    { id: '3', name: 'Massagem' },
    { id: '4', name: 'Pedicure' },
    { id: '5', name: 'Design de sobrancelhas' },
  ];

  const handleSelectService = (serviceId: string) => {
    if (selectedServices.includes(serviceId)) {
      setSelectedServices(selectedServices.filter(id => id !== serviceId));
    } else {
      setSelectedServices([...selectedServices, serviceId]);
    }
  };

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.title}>Serviços Oferecidos</Text>
      <FlatList
        data={services}
        renderItem={({ item }) => (
          <TouchableOpacity
            style={styles.service}
            onPress={() => handleSelectService(item.id)}
          >
            <Text style={styles.serviceText}>{item.name}</Text>
            {selectedServices.includes(item.id) && (
              <Ionicons name="checkmark-circle" size={24} color="#ff65b5" />
            )}
          </TouchableOpacity>
        )}
        keyExtractor={item => item.id}
      />
      <TouchableOpacity
        style={styles.button}
        onPress={() => console.log(selectedServices)}
      >
        <Text style={styles.buttonText}>Salvar</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
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
  service: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: 16,
    marginBottom: 8,
    borderRadius: 8,
    backgroundColor: '#fff',
  },
  serviceText: {
    fontSize: 16,
  },
  button: {
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
  },
});
