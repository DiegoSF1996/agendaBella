import { GestureHandlerRootView } from 'react-native-gesture-handler';
import { Drawer } from 'expo-router/drawer';
import { AuthProvider, useAuth } from '../context/AuthContext';
import * as SplashScreen from 'expo-splash-screen';
import { useEffect, useCallback, useState } from 'react';
import { View } from 'react-native';

// Isso evita o splash desaparecer automaticamente
SplashScreen.preventAutoHideAsync();

function DrawerContent() {
  const { isLoggedIn, tipoUsuario } = useAuth();
  const [appIsReady, setAppIsReady] = useState(false);

  // Simula um carregamento (pode ser sua lógica de autenticação)
  useEffect(() => {
    async function prepare() {
      try {
        // Aqui você pode carregar dados ou autenticar o usuário
        await new Promise(resolve => setTimeout(resolve, 1000));
      } catch (e) {
        console.warn(e);
      } finally {
        setAppIsReady(true);
      }
    }

    prepare();
  }, []);

  // Esconde o splash quando a tela estiver pronta
  const onLayoutRootView = useCallback(async () => {
    if (appIsReady) {
      await SplashScreen.hideAsync();
    }
  }, [appIsReady]);

  if (!appIsReady) {
    return null; // ou um loading temporário
  }

  return (
    <GestureHandlerRootView style={{ flex: 1 }} onLayout={onLayoutRootView}>
      <Drawer screenOptions={{
        headerStyle: {
          backgroundColor: '#ea40c0',
        },
        headerTintColor: '#ffe4e0',
        headerTitleStyle: {
          fontWeight: 'bold',
        },
        drawerActiveBackgroundColor: '#ffa3c6',
        drawerActiveTintColor: '#fffbec',
        drawerInactiveTintColor: '#ff65b5',
      }}>
        <Drawer.Protected guard={!isLoggedIn}>
          <Drawer.Screen name="index" options={{ title: 'Login' }} />
          <Drawer.Screen name="login" options={{ title: 'Login', drawerItemStyle: { display: 'none' } }} />
          <Drawer.Screen name="registrar" options={{ title: 'Registrar', drawerItemStyle: { display: 'none' } }} />

          <Drawer.Protected guard={tipoUsuario === 'pf'}>
            <Drawer.Screen name="pf/home/index" options={{ title: 'Agendamentos' }} />
            <Drawer.Screen name="pf/agendar/index" options={{ title: 'Agendar' }} />
            <Drawer.Screen name="pf/agendar/listarEstabelecimentos/index" options={{ title: 'Estabelecimentos', drawerItemStyle: { display: 'none' } }} />
            <Drawer.Screen name="pf/agendar/listarEstabelecimentos/escolherHorario/index" options={{ title: 'Escolher horário', drawerItemStyle: { display: 'none' } }} />
            <Drawer.Screen name="pf/historico/index" options={{ title: 'Histórico' }} />
          </Drawer.Protected>

          <Drawer.Protected guard={tipoUsuario === 'pj'}>
            <Drawer.Screen name="pj/home/index" options={{ title: 'Atendimentos' }} />
            <Drawer.Screen name="pj/servicosOferecidos/index" options={{ title: 'Serviços' }} />
            <Drawer.Screen name="pj/historico/index" options={{ title: 'Histórico' }} />

          </Drawer.Protected>
        </Drawer.Protected>

        <Drawer.Protected guard={isLoggedIn}>
          <Drawer.Screen name="logout" />
        </Drawer.Protected>

        <Drawer.Screen name="+not-found" options={{ drawerItemStyle: { display: 'none' } }} />
      </Drawer>
    </GestureHandlerRootView>
  );
}

export default function Layout() {
  return (
    <AuthProvider>
      <DrawerContent />
    </AuthProvider>
  );
}
