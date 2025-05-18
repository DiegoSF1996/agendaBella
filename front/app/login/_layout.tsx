import { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import { Link, useRouter } from 'expo-router';
import { useAuth } from '../../context/AuthContext';

export default function LoginScreen() {
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const router = useRouter();
  const { login, user } = useAuth();

  const handleLogin = async () => {
    if (!email || !senha) {
      Alert.alert('Erro', 'Preencha todos os campos');
      return;
    }

    login(email,'pj');
    router.replace('/pj/home');
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Login</Text>

      <TextInput
        style={styles.input}
        placeholder="E-mail"
        value={email}
        onChangeText={setEmail}
        autoCapitalize="none"
      />

      <TextInput
        style={styles.input}
        placeholder="Senha"
        value={senha}
        onChangeText={setSenha}
        secureTextEntry
      />

      <TouchableOpacity style={styles.button} onPress={handleLogin}>
        <Text style={styles.buttonText}>Entrar</Text>
      </TouchableOpacity>
      
      <Text style={{ textAlign: 'center' }} >Ainda não tem uma conta? <Link style={{color: '#ff65b5'}} href="/registrar">Criar Conta</Link> </Text>
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, justifyContent: 'center', paddingHorizontal: 30 },
  title: { color: '#ff65b5', fontSize: 32, textAlign: 'center', marginBottom: 40, fontWeight: 'bold' },
  input: { backgroundColor: '#fffbec', padding: 15, marginBottom: 20, borderRadius: 8 },
  button: { backgroundColor: '#ff65b5', padding: 15, borderRadius: 8, alignItems: 'center' },
  buttonText: { color: '#fffbec', fontWeight: 'bold', fontSize: 16 },
});
