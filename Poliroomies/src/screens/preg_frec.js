import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  TextInput,
  ImageBackground,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { ChevronDown, ChevronUp, ArrowLeft } from 'lucide-react-native';
import { useNavigation } from '@react-navigation/native';

const FAQItem = ({ question, answer }) => {
  const [expanded, setExpanded] = useState(false);

  return (
    <View style={styles.faqItem}>
      <TouchableOpacity
        onPress={() => setExpanded(!expanded)}
        style={styles.faqQuestionContainer}
      >
        <Text style={styles.faqQuestion}>{question}</Text>
        {expanded ? (
          <ChevronUp size={20} color="#B00020" />
        ) : (
          <ChevronDown size={20} color="#B00020" />
        )}
      </TouchableOpacity>
      {expanded && (
        <Text style={styles.faqAnswer}>
          {'   '}
          {answer}
        </Text>
      )}
    </View>
  );
};

const FAQScreen = () => {
  const [searchQuery, setSearchQuery] = useState('');
  const navigation = useNavigation();
  const faqs = [
    {
      question: '¿Cómo puedo encontrar un roomie?',
      answer:
        'Puedes usar la función de búsqueda y filtrado para encontrar posibles compañeros de piso según tus preferencias.',
    },
    {
      question: '¿Cómo funciona el sistema de mensajería?',
      answer:
        'Una vez que encuentres un roomie potencial, puedes iniciar una conversación a través de nuestra plataforma de mensajería segura.',
    },
    {
      question: '¿Puedo dejar reseñas sobre mis roomies anteriores?',
      answer:
        'Sí, nuestra plataforma te permite dejar reseñas y calificaciones sobre tus experiencias con compañeros de piso anteriores.',
    },
    {
      question: '¿Cómo garantizan mi seguridad y privacidad?',
      answer:
        'Implementamos medidas de seguridad robustas para proteger tus datos personales y verificación de identidad para mayor confianza.',
    },
    {
      question: '¿Qué hago si tengo un problema con la aplicación?',
      answer:
        'Puedes contactar a nuestro equipo de soporte a través de la sección "Soporte" en la configuración.',
    },
  ];

  const filteredFaqs = faqs.filter((faq) =>
    faq.question.toLowerCase().includes(searchQuery.toLowerCase())
  );

  return (
    <SafeAreaView style={styles.safeArea}>
      <ImageBackground
        source={require('../../assets/logo_fondo.jpeg')} // asegúrate de tener esta imagen
        style={styles.background}
        imageStyle={{ opacity: 0.05 }}
      >
        {/* Barra superior */}
        <View style={styles.topBar}>
          <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
            <ArrowLeft color="#fff" size={24} />
          </TouchableOpacity>
          <Text style={styles.screenTitle}>Preguntas Frecuentes</Text>
        </View>

        {/* Barra de búsqueda */}
        <View style={styles.searchContainer}>
          <TextInput
            placeholder="Buscar pregunta..."
            placeholderTextColor="#ccc"
            value={searchQuery}
            onChangeText={setSearchQuery}
            style={styles.searchInput}
          />
        </View>

        <ScrollView contentContainerStyle={styles.scroll}>
          <View style={styles.categoryBox}>
            <Text style={styles.categoryTitle}>Categoría General</Text>
            {filteredFaqs.map((faq, index) => (
              <FAQItem
                key={index}
                question={faq.question}
                answer={faq.answer}
              />
            ))}
          </View>
        </ScrollView>
      </ImageBackground>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#001F54', // Azul marino como base
  },
  background: {
    flex: 1,
  },
  topBar: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#B00020', // Rojo dominante
    paddingHorizontal: 16,
    paddingVertical: 12,
  },
  backButton: {
    marginRight: 12,
  },
  screenTitle: {
    fontSize: 20,
    color: '#fff',
    fontWeight: 'bold',
  },
  searchContainer: {
    backgroundColor: '#002E6D',
    padding: 10,
  },
  searchInput: {
    backgroundColor: '#fff',
    borderRadius: 8,
    paddingHorizontal: 12,
    height: 40,
    fontSize: 14,
    color: '#333',
  },
  scroll: {
    padding: 16,
  },
  categoryBox: {
    backgroundColor: '#003366',
    borderRadius: 12,
    padding: 16,
    marginBottom: 20,
    shadowColor: '#000',
    shadowOffset: { width: 1, height: 2 },
    shadowOpacity: 0.15,
    shadowRadius: 4,
    elevation: 4,
  },
  categoryTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 12,
  },
  faqItem: {
    backgroundColor: '#fff', // fondo blanco
    padding: 14,
    borderRadius: 10,
    marginBottom: 10,
    borderLeftWidth: 6,
    borderLeftColor: '#B00020', // borde rojo
  },
  faqQuestionContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  faqQuestion: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#B00020', // texto rojo
    flex: 1,
    marginRight: 10,
  },
  faqAnswer: {
    fontSize: 14,
    color: '#B00020', // texto rojo
    marginTop: 8,
    marginLeft: 10,
    lineHeight: 20,
  },
});

export default FAQScreen;
