import React, { useState, useRef } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert, Platform } from 'react-native';
import { useRouter } from 'expo-router';
import { useAuth } from '../../../context/AuthContext';
import DropDownPicker from 'react-native-dropdown-picker';
import CustomDropdown, { DropdownItem } from '../../../components/custom/DropDownPicker';

export default function NovoAgendamentoScreen() {
    const [emMinhaCidade, setEmMinhaCidade] = useState(false);
    const [cnpj, setCnpj] = useState('');
    const [nomeFantasia, setNomeFantasia] = useState('');
    const [nomeCompleto, setNomeCompleto] = useState('');
    const [cpf, setCpf] = useState('');
    const [nomeUsuario, setNomeUsuario] = useState('');
    const [email, setEmail] = useState('');
    const [senha, setSenha] = useState('');
    const [errors, setErrors] = useState<{ [key: string]: string }>({});

    const router = useRouter();
    const { login } = useAuth();
 //sudo npx expo install @react-native-picker/picker
    const validateEmail = (email: string) => {
        const re = /\S+@\S+\.\S+/;
        return re.test(email);
    };


    const validateCpf = (cpf: string): boolean => {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

        let sum = 0;
        for (let i = 0; i < 9; i++) sum += parseInt(cpf.charAt(i)) * (10 - i);
        let rev = 11 - (sum % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) sum += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (sum % 11);
        if (rev === 10 || rev === 11) rev = 0;
        return rev === parseInt(cpf.charAt(10));
    };

    const validateCnpj = (cnpj: string): boolean => {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj.length !== 14 || /^(\d)\1+$/.test(cnpj)) return false;

        let length = cnpj.length - 2;
        let numbers = cnpj.substring(0, length);
        const digits = cnpj.substring(length);
        let sum = 0;
        let pos = length - 7;

        for (let i = length; i >= 1; i--) {
            sum += +numbers.charAt(length - i) * pos--;
            if (pos < 2) pos = 9;
        }

        let result = sum % 11 < 2 ? 0 : 11 - (sum % 11);
        if (result !== +digits.charAt(0)) return false;

        length = length + 1;
        numbers = cnpj.substring(0, length);
        sum = 0;
        pos = length - 7;

        for (let i = length; i >= 1; i--) {
            sum += +numbers.charAt(length - i) * pos--;
            if (pos < 2) pos = 9;
        }

        result = sum % 11 < 2 ? 0 : 11 - (sum % 11);
        return result === +digits.charAt(1);
    };


    const handleRegister = () => {
        router.push('pf/agendar/listarEstabelecimentos');
    };
    const [selectedCidades, setSelectedCidades] = useState<string | number | null>(null);
    
    const cidades: DropdownItem[] = [
        { label: 'Bahia', value: 'bahia' },
        { label: 'São Paulo', value: 'alisamento' },
        { label: 'Rio de Janeiro', value: 'depilacao' },
    ];

    const [selectedEstados, setSelectedEstados] = useState<string | number | null>(null);
    
    const estados: DropdownItem[] = [
        { label: 'Bahia', value: 'bahia' },
        { label: 'São Paulo', value: 'alisamento' },
        { label: 'Rio de Janeiro', value: 'depilacao' },
    ];

    const [selectedEstabelecimento, setSelectedEstabelecimento] = useState<string | number | null>(null);
    
    const estabelecimentos: DropdownItem[] = [
        { label: 'Manicure', value: 'manicure' },
        { label: 'Alisamento', value: 'alisamento' },
        { label: 'Depilação', value: 'depilacao' },
    ];

    const [selectedServico, setSelectedServico] = useState<string | number | null>(null);
    
    const servicos: DropdownItem[] = [
        { label: 'Manicure', value: 'manicure' },
        { label: 'Alisamento', value: 'alisamento' },
        { label: 'Depilação', value: 'depilacao' },
    ];

    return (
        <View style={styles.container} >

            <Text style={styles.title}>Agendar</Text>

            {/* Radio para selecionar tipo */}
            <View style={styles.radioGroup}>
                <TouchableOpacity style={styles.radioOption} onPress={() => setEmMinhaCidade(true)}>
                    <View style={[styles.radioCircle, emMinhaCidade && styles.radioChecked]} />
                    <Text style={styles.radioLabel}>Em minha cidade</Text>
                </TouchableOpacity>

                <TouchableOpacity style={styles.radioOption} onPress={() => setEmMinhaCidade(false)}>
                    <View style={[styles.radioCircle, !emMinhaCidade && styles.radioChecked]} />
                    <Text style={styles.radioLabel}>Em outra cidade</Text>
                </TouchableOpacity>
            </View>
            {!emMinhaCidade && (
                <>
                    <CustomDropdown
                    style={styles.input}
                    items={estados}
                    value={selectedEstados}
                    setValue={setSelectedEstados}
                    placeholder="Escolha o Estado"
                    />
                    
                    <CustomDropdown
                    style={styles.input}
                    items={cidades}
                    value={selectedCidades}
                    setValue={setSelectedCidades}
                    placeholder="Escolha a Cidade"
                    />
                </>
            )}
            <CustomDropdown
                    style={styles.input}
                    items={servicos}
                    value={selectedServico}
                    setValue={setSelectedServico}
                    placeholder="Escolha o Serviço"
            />
            <CustomDropdown
                    style={styles.input}
                    items={estabelecimentos}
                    value={selectedEstabelecimento}
                    setValue={setSelectedEstabelecimento}
                    placeholder="Escolha o Estabelecimento"
            />

            <TouchableOpacity style={styles.button} onPress={handleRegister}>
                <Text style={styles.buttonText}>Buscar</Text>
            </TouchableOpacity>
        </View>
    );
}

const styles = StyleSheet.create({
    container: { flex: 1, justifyContent: 'center', paddingHorizontal: 30 },
    title: { color: '#ff65b5', fontSize: 32, textAlign: 'center', marginBottom: 40, fontWeight: 'bold' },
    input: {
        backgroundColor: '#fffbec',
        padding: Platform.OS === 'ios' ? 15 : 10,
        marginBottom: 20,
        borderRadius: 8,
    },
    button: { backgroundColor: '#ff65b5', padding: 15, borderRadius: 8, alignItems: 'center' },
    buttonText: { color: '#fffbec', fontWeight: 'bold', fontSize: 16 },
    radioGroup: { flexDirection: 'row', justifyContent: 'center', marginBottom: 20 },
    radioOption: { flexDirection: 'row', alignItems: 'center', marginHorizontal: 15 },
    radioCircle: {
        height: 20,
        width: 20,
        borderRadius: 10,
        borderWidth: 2,
        borderColor: '#ff65b5',
        marginRight: 10,
        justifyContent: 'center',
        alignItems: 'center',
    },
    radioChecked: {
        backgroundColor: '#ff65b5',
    },
    radioLabel: {
        fontSize: 16,
        color: '#333',
    },
    error: {
        color: '#ff2d55',
        marginBottom: 10,
        marginTop: -15,
        fontSize: 12,
    }

});
