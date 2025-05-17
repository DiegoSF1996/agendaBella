import { GestureHandlerRootView } from 'react-native-gesture-handler';
import { Drawer } from 'expo-router/drawer';
import { AuthProvider, useAuth } from '../context/AuthContext';
import { Text } from 'react-native';




function DrawerContent() {
  const { isLoggedIn,tipoUsuario } = useAuth();
  
  return (
    <GestureHandlerRootView style={{ flex: 1 }}>
      {/* <Text>{isLoggedIn ? 'Logado' : 'Não logado'}</Text> */}
      <Drawer screenOptions={{
        headerStyle: {
          backgroundColor: '#ea40c0',
        },
        headerTintColor: '#ffe4e0',
        headerTitleStyle: {
          fontWeight: 'bold',
        },
        drawerActiveBackgroundColor: '#ffa3c6', // cor do background da borda no item selecionado
        drawerActiveTintColor: '#fffbec',       // cor do texto do item selecionado
        drawerInactiveTintColor: '#ff65b5',        // cor do texto do item não selecionad
      }}>
        <Drawer.Protected guard={!isLoggedIn} >
          <Drawer.Screen name="index" options={{ title: 'Inicio' }} />
          <Drawer.Screen name="login" options={{title: 'Login'}} />
          <Drawer.Screen name="registrar" options={{ title: 'Registrar', drawerItemStyle: { display: 'none' } }} />
          {/* Rotas de pessoas fisicas e juridicas */}
          <Drawer.Protected guard={tipoUsuario === 'pf'}  >
            <Drawer.Screen name="pf/home/index" options={{ title: 'Home PF' }} />
          </Drawer.Protected>
          <Drawer.Protected guard={tipoUsuario === 'pj'} >
            <Drawer.Screen name="pj/home/index" options={{ title: 'Home PJ' }} />
          </Drawer.Protected>
          {/* Fim Rotas de pessoas fisicas e juridicas */}
        </Drawer.Protected>
        
        <Drawer.Protected guard={isLoggedIn} >
          <Drawer.Screen name="home" options={{ title: 'Home' }} />
          <Drawer.Screen name='logout' />
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
