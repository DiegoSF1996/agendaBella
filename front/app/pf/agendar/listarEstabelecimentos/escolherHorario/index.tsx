import React from 'react';
import { View, Text, StyleSheet, FlatList, TouchableOpacity } from 'react-native';
import { router, useLocalSearchParams } from 'expo-router';


import { Ionicons } from '@expo/vector-icons';

interface Props {
    estabelecimento: string;
    tipoServico: string;
    empresa: {
        nome: string;
        endereco: string;
        avaliacao: number;
    };
}

const escolherHorarioScreen = (props: Props) => {
    let { estabelecimento, tipoServico, empresa } = useLocalSearchParams() ;
    console.log(estabelecimento, tipoServico, empresa);
    empresa = JSON.parse(empresa);
    //console.log(route.params);
    // const { estabelecimento, tipoServico, empresa } = route.useLocalSearchParams();

    const horarios = [
        { id: '1', horario: '08:00', disponivel: true },
        { id: '2', horario: '09:00', disponivel: true },
        { id: '3', horario: '10:00', disponivel: false },
        { id: '4', horario: '11:00', disponivel: true },
        { id: '5', horario: '12:00', disponivel: false },
        { id: '6', horario: '13:00', disponivel: true },
        { id: '7', horario: '14:00', disponivel: false },
        { id: '8', horario: '15:00', disponivel: true },
        { id: '9', horario: '16:00', disponivel: false },
        { id: '10', horario: '17:00', disponivel: true },
    ];

    const handleSelectHorario = (horario: string) => {
        console.log(`Horário selecionado: ${horario}`);
    };

    return (
        <View style={styles.container}>
            <TouchableOpacity style={styles.backButton} onPress={() => router.back()}>
                <Ionicons name="arrow-back" size={24} color="#ff65b5" />
                <Text style={styles.backText}>Voltar</Text>
            </TouchableOpacity>
            <Text style={styles.title}>Escolha o horário para {estabelecimento}</Text>
            <Text style={styles.subtitle}>{tipoServico}</Text>

            <View style={styles.empresaContainer}>
                <Text style={styles.empresaName}>{empresa.nome}</Text>
                <Text style={styles.empresaEndereco}>{empresa.endereco}</Text>
                <Text style={styles.empresaAvaliacao}>{empresa.avaliacao} estrelas</Text>
            </View>

            <FlatList
                data={horarios}
                keyExtractor={item => item.id}
                renderItem={({ item }) => (
                    <TouchableOpacity
                        style={[styles.horarioContainer, { backgroundColor: item.disponivel ? '#fff' : '#ccc' }]}
                        onPress={() => handleSelectHorario(item.horario)}
                    >
                        <Text style={styles.horario}>{item.horario}</Text>
                        <Ionicons name={item.disponivel ? 'checkmark-circle' : 'close-circle'} size={24} color={item.disponivel ? '#00ff00' : '#ff0000'} />
                    </TouchableOpacity>
                )}
            />
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        paddingHorizontal: 16,
        paddingVertical: 24,
    },
    title: {
        fontSize: 24,
        fontWeight: 'bold',
        marginBottom: 16,
    },
    subtitle: {
        fontSize: 18,
        marginBottom: 16,
    },
    empresaContainer: {
        paddingVertical: 16,
        borderBottomWidth: 1,
        borderBottomColor: '#ccc',
    },
    empresaName: {
        fontSize: 16,
        marginBottom: 8,
    },
    empresaEndereco: {
        fontSize: 14,
        marginBottom: 8,
    },
    empresaAvaliacao: {
        fontSize: 14,
        color: '#666',
    },
    horarioContainer: {
        paddingVertical: 16,
        flexDirection: 'row',
        alignItems: 'center',
        justifyContent: 'space-between',
    },
    horario: {
        fontSize: 16,
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

export default escolherHorarioScreen;

