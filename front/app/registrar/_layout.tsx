import React, { useState } from 'react';
import { ScrollView, View, Text, TextInput, TouchableOpacity, StyleSheet, Alert, Platform } from 'react-native';
import { useRouter } from 'expo-router';
import { useAuth } from '../../context/AuthContext';

export default function RegisterScreen() {
    const [isPJ, setIsPJ] = useState(false);
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
        const newErrors: { [key: string]: string } = {};
        if (!nomeUsuario || nomeUsuario.length < 3) {
            newErrors.nomeUsuario = 'Nome de usuário deve ter no mínimo 3 caracteres';
        }

        if (!email || !validateEmail(email)) {
            newErrors.email = 'Erro E-mail inválido';
        }

        if (!senha || senha.length < 6) {
            newErrors.senha = 'Erro Senha deve ter no mínimo 6 caracteres';
        }

        if (isPJ) {
            if (!cnpj || !validateCnpj(cnpj)) {
                newErrors.cnpj = 'Erro CNPJ inválido';
            }
            if (!nomeFantasia || nomeFantasia.length < 3) {
                newErrors.nomeFantasia = 'Erro Nome fantasia deve ter no mínimo 3 caracteres';
            }
        } else {
            if (!nomeCompleto || nomeCompleto.length < 5) {
                newErrors.nomeCompleto = 'Erro Nome completo deve ter no mínimo 5 caracteres';
            }
            if (!cpf || !validateCpf(cpf)) {
                newErrors.cpf = 'Erro CPF inválido';
            }
        }

        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            return;
        }

        setErrors({}); // limpa erros

        // Tudo válido
        login(nomeUsuario);
        console.log('Sucesso Cadastro realizado com sucesso!');
        router.replace('/login');
    };


    return (
        <ScrollView contentContainerStyle={styles.container}>

            <Text style={styles.title}>Cadastro</Text>

            {/* Radio para selecionar tipo */}
            <View style={styles.radioGroup}>
                <TouchableOpacity style={styles.radioOption} onPress={() => setIsPJ(false)}>
                    <View style={[styles.radioCircle, !isPJ && styles.radioChecked]} />
                    <Text style={styles.radioLabel}>Pessoa Física</Text>
                </TouchableOpacity>

                <TouchableOpacity style={styles.radioOption} onPress={() => setIsPJ(true)}>
                    <View style={[styles.radioCircle, isPJ && styles.radioChecked]} />
                    <Text style={styles.radioLabel}>Pessoa Jurídica</Text>
                </TouchableOpacity>
            </View>

            {/* Campos dinâmicos */}
            {isPJ ? (
                <>
                    <TextInput
                        style={styles.input}
                        placeholder="CNPJ"
                        value={cnpj}
                        onChangeText={text => {
                            setCnpj(text);
                            setErrors(prev => ({ ...prev, cnpj: '' }));
                        }}
                        keyboardType="numeric"
                    />
                    {errors.cnpj ? <Text style={styles.error}>{errors.cnpj}</Text> : null}
                    <TextInput
                        style={styles.input}
                        placeholder="Nome Fantasia"
                        value={nomeFantasia}
                        onChangeText={text => {
                            setNomeFantasia(text);
                            setErrors(prev => ({ ...prev, nomeFantasia: '' }));
                        }}
                    />
                    {errors.nomeFantasia ? <Text style={styles.error}>{errors.nomeFantasia}</Text> : null}
                </>
            ) : (
                <>
                    <TextInput
                        style={styles.input}
                        placeholder="Nome Completo"
                        value={nomeCompleto}
                        onChangeText={text => {
                            setNomeCompleto(text);
                            setErrors(prev => ({ ...prev, nomeCompleto: '' }));
                        }}
                    />
                    {errors.nomeCompleto ? <Text style={styles.error}>{errors.nomeCompleto}</Text> : null}
                    <TextInput
                        style={styles.input}
                        placeholder="CPF"
                        value={cpf}
                        onChangeText={text => {
                            setCpf(text);
                            setErrors(prev => ({ ...prev, cpf: '' }));
                        }}
                        keyboardType="numeric"
                    />
                    {errors.cpf ? <Text style={styles.error}>{errors.cpf}</Text> : null}
                </>
            )}

            <TextInput
                style={styles.input}
                placeholder="Nome de Usuário"
                value={nomeUsuario}
                onChangeText={text => {
                    setNomeUsuario(text);
                    setErrors(prev => ({ ...prev, nomeUsuario: '' }));
                }}
                autoCapitalize="none"
            />
            {errors.nomeUsuario ? <Text style={styles.error}>{errors.nomeUsuario}</Text> : null}
            <TextInput
                style={styles.input}
                placeholder="E-mail"
                value={email}
                onChangeText={text => {
                    setEmail(text);
                    setErrors(prev => ({ ...prev, email: '' }));
                }}
                autoCapitalize="none"
                keyboardType="email-address"
            />
            {errors.email ? <Text style={styles.error}>{errors.email}</Text> : null}
            <TextInput
                style={styles.input}
                placeholder="Senha"
                value={senha}
                onChangeText={text => {
                    setSenha(text);
                    setErrors(prev => ({ ...prev, senha: '' }));
                }}
                secureTextEntry
            />
            {errors.senha ? <Text style={styles.error}>{errors.senha}</Text> : null}

            <TextInput
                style={styles.input}
                placeholder="Logradouro"
                value={nomeUsuario}
                onChangeText={text => {
                    setNomeUsuario(text);
                    setErrors(prev => ({ ...prev, nomeUsuario: '' }));
                }}
                autoCapitalize="none"
            />
            <TextInput
                style={styles.input}
                placeholder="Número"
                value={nomeUsuario}
                onChangeText={text => {
                    setNomeUsuario(text);
                    setErrors(prev => ({ ...prev, nomeUsuario: '' }));
                }}
                autoCapitalize="none"
            />
            <TextInput
                style={styles.input}
                placeholder="Complemento"
                value={nomeUsuario}
                onChangeText={text => {
                    setNomeUsuario(text);
                    setErrors(prev => ({ ...prev, nomeUsuario: '' }));
                }}
                autoCapitalize="none"
            />
            <TextInput
                style={styles.input}
                placeholder="CEP"
                value={nomeUsuario}
                onChangeText={text => {
                    setNomeUsuario(text);
                    setErrors(prev => ({ ...prev, nomeUsuario: '' }));
                }}
                keyboardType="numeric"
            />
            <TouchableOpacity style={styles.button} onPress={handleRegister}>
                <Text style={styles.buttonText}>Cadastrar</Text>
            </TouchableOpacity>
        </ScrollView>
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
