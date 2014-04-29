#ifndef _TELEFONO_H_
#define _TELEFONO_H_

#include <iostream>
#include <ctime>
#include "libs/Screen.cpp"

char NUM[15];
int index_;
int llamar = 0, MOD;


Screen screen(500,780, (char*)"AndroidOS", (char*)"files/img/icono.bmp");
Polygon2D pantalla, boton_home, boton_home_;

int getDistancia( int x0, int y0, int x1, int y1 ){
	int deltaX = x0-x1;
	int deltaY = y1-y0;
	return (int)sqrt( deltaX*deltaX + deltaY*deltaY );
}

void init_( ){
	screen.init_SDL( );

	boton_home.createCircle( 250,22, 20 );
	boton_home_.createCircle( 250, 22, 12 );
	
	pantalla.create( );
	pantalla.pushVertex( 20, 45 );
	pantalla.pushVertex( 480, 45 );
	pantalla.pushVertex( 480, 760 );
	pantalla.pushVertex( 20, 760 );
	pantalla.close( );

	//pantalla.fillPolygon( screen, 0xffffff );
}

void mostrar_reloj( ){
    /* Reloj */
    time_t tiempo = time(0);
    struct tm *tlocal = localtime(&tiempo);
    char output[128];
    strftime(output,128,"%H:%M",tlocal);
    int hora, minuto;
    sscanf(output,"%d:%d",&hora,&minuto);
    if( hora > 12 )
        sprintf(output,"%02d:%02d pm",hora%12,minuto);
    else
        sprintf(output,"%02d:%02d am",hora,minuto);  	
	screen.print( output, 385,758, 250, 250, 250, 6 );
}

void mostrar_extras( ){
/* Bateria */
    Polygon2D bateria;
    bateria.create( );
    bateria.pushVertex( 338, 740 );
    bateria.pushVertex( 365, 740 );
    bateria.pushVertex( 365, 743 );
    bateria.pushVertex( 368, 743 );
    bateria.pushVertex( 368, 752 );
    bateria.pushVertex( 365, 752 );
    bateria.pushVertex( 365, 755 );
    bateria.pushVertex( 338, 755 );
    bateria.close( );
    bateria.fillPolygon( screen, 0xffffff );
    
    /* 3G */
    screen.print( (char*)"3G", 302, 760, 250, 250,250,6 );

  /* barras seńal */
    Polygon2D barra1;
    barra1.create( );
    barra1.pushVertex( 280, 736 );
    barra1.pushVertex( 282, 736 );
    barra1.pushVertex( 282, 741 );
    barra1.pushVertex( 280, 741 );
    barra1.close( );
    barra1.fillPolygon( screen, 0xffffff );

    Polygon2D barra2;
    barra2.create( );
    barra2.pushVertex( 284, 736 );
    barra2.pushVertex( 286, 736 );
    barra2.pushVertex( 286, 746 );
    barra2.pushVertex( 284, 746 );
    barra2.close( );
    barra2.fillPolygon( screen, 0xffffff );

    Polygon2D barra3;
    barra3.create( );
    barra3.pushVertex( 288, 736 );
    barra3.pushVertex( 290, 736 );
    barra3.pushVertex( 290, 751 );
    barra3.pushVertex( 288, 751 );
    barra3.close( );
    barra3.fillPolygon( screen, 0xffffff );

    Polygon2D barra4;
    barra4.create( );
    barra4.pushVertex( 292, 736 );
    barra4.pushVertex( 294, 736 );
    barra4.pushVertex( 294, 754 );
    barra4.pushVertex( 292, 754 );
    barra4.close( );
    barra4.fillPolygon( screen, 0xffffff );

    Polygon2D barra5;
    barra5.create( );
    barra5.pushVertex( 296, 736 );
    barra5.pushVertex( 298, 736 );
    barra5.pushVertex( 298, 756 );
    barra5.pushVertex( 296, 756 );
    barra5.close( );
    barra5.fillPolygon( screen, 0xffffff );
}

void mostrar_boton_home( ){
	boton_home.fillPolygon( screen, 0x332c2c );
	boton_home_.drawPolygon( screen, 0xffffff );
}

void mostrar_barra_superior( ){
	for( int i=20; i<480; i++ )
		for( int j=735; j<760; j++ )
			screen.putTransparencia( i, j );

	mostrar_extras( );
	mostrar_reloj( );
}

void mostrar_wallpaper( ){
	Polygon2D wallpaper;
	wallpaper.create( );
	wallpaper.pushVertex( 20, 45 );
	wallpaper.pushVertex( 480, 45 );
	wallpaper.pushVertex( 480, 760 );
	wallpaper.pushVertex( 20, 760 );
	wallpaper.close( );
	wallpaper.fillPolygon( screen, 0x6BAEFF );

	Polygon2D barra;
	barra.create( );
	barra.pushVertex(20,45);
	barra.pushVertex(60,45);
	barra.pushVertex(60,760);
	barra.pushVertex(20,760);
	barra.close( );

	barra.fillPolygon( screen, 0x5673E8 );
	for( int i=60; i< 500; i+=70 ){
		barra.matrix.displace(70.0, 0);
		barra.fillPolygon( screen, 0x5673E8 );
	}
}

void mostrar_widgets( ){
    /* Reloj */
    time_t tiempo = time(0);
    struct tm *tlocal = localtime(&tiempo);
    char output[128];
    strftime(output,128,"%H:%M:%S",tlocal);
    int hora, minuto, segundo;
    sscanf(output,"%d:%d:%d",&hora,&minuto,&segundo);
    sprintf(output,"%02d:%02d",hora%12,minuto);
    screen.print( output, 29, 680, 250, 250, 250, 7);

	screen.print("13 Frebrero ", 190, 657, 250, 250, 250, 2);	

	Polygon2D barrita;
	screen.drawLine( 40,620,380,620, 0xffffff);

}	

void app_mensajes( ){
	Polygon2D mensajes;
	mensajes.create(  );
	mensajes.pushVertex( 0, 0 );
	mensajes.pushVertex( 10, 0 );
	mensajes.pushVertex( 10, 10 );
	mensajes.pushVertex( 0, 10 );
	mensajes.close( );

	/*primer renglon*/
	mensajes.matrix.scale( 10 , 10 );
	mensajes.matrix.displace( 5, 9 );
//	mensajes.fillPolygon( screen, 0x76F7FF );


	mensajes.matrix.displace( 15,0);
//	mensajes.fillPolygon( screen, 0x76F7FF );

	mensajes.matrix.displace( 15,0);
//	mensajes.fillPolygon( screen, 0x76F7FF );	


	/* segundo renglon */
	mensajes.matrix.displace( -30, 18 );
	mensajes.fillPolygon( screen, 0x144A63 );
	screen.drawIcon( 65, 420,3 );
	screen.print("Reloj", 68, 272, 0 , 0, 0, 0);

	mensajes.matrix.displace( 15,0);
	//mensajes.fillPolygon( screen, 0x76F7FF );

	mensajes.matrix.displace( 15,0);
	//mensajes.fillPolygon( screen, 0x76F7FF );


	/* tercer renglon */
	mensajes.matrix.displace( -30, 18 );
	mensajes.fillPolygon( screen, 0xFFFFFF );
	screen.drawIcon( 58, 240, 0);
	screen.print("Twitter", 68, 450, 0 , 0, 0, 0);

	mensajes.matrix.displace( 15,0);
	mensajes.fillPolygon( screen, 0x144A63);
	screen.drawIcon(210,240,1);
	screen.print("Telefono",210,450,0,0,0,0);

	mensajes.matrix.displace( 15,0);
	mensajes.fillPolygon( screen, 0xFFFFFF );
	screen.drawIcon(362, 240, 2);
	screen.print("Notas",372,450,0,0,0,0);
}



void APP_RELOJ( ){
	Polygon2D PantallaPrincipal;

	PantallaPrincipal.clear( );
	PantallaPrincipal.create( );
	PantallaPrincipal.pushVertex( 20, 45 );
	PantallaPrincipal.pushVertex( 480, 45 );
	PantallaPrincipal.pushVertex( 480, 760 );
	PantallaPrincipal.pushVertex( 20, 760 );
	PantallaPrincipal.close( );
	PantallaPrincipal.fillPolygon( screen, 0x144A63);

	 /* Reloj */
    time_t tiempo = time(0);
    struct tm *tlocal = localtime(&tiempo);
    char output[128];
    strftime(output,128,"%H:%M:%S",tlocal);
    int hora, minuto, segundo;

    sscanf(output,"%d:%d:%d",&hora,&minuto,&segundo);
    //HORA
    sprintf(output,"%02d",hora%12);
    screen.print( output, 29, 660, 250, 250, 250, 4);
    //MINUTO
    sprintf(output,"%02d",minuto);
    screen.print( output, 159, 500, 250, 250, 250, 4);
    //SEGUNDO
    sprintf(output,"%02d",segundo);
    screen.print( output, 259, 320, 250, 250, 250, 4);
    
}

void APP_NOTAS( ){

	Polygon2D PantallaPrincipal;
	PantallaPrincipal.clear( );
	PantallaPrincipal.create( );
	PantallaPrincipal.pushVertex( 20, 45 );
	PantallaPrincipal.pushVertex( 480, 45 );
	PantallaPrincipal.pushVertex( 480, 760 );
	PantallaPrincipal.pushVertex( 20, 760 );
	PantallaPrincipal.close( );
	PantallaPrincipal.fillPolygon( screen, 0xDFDA7F);	

	Polygon2D barrita;
	barrita.clear( );
	barrita.create( );
	barrita.pushVertex(20,45);
	barrita.pushVertex(480,45);
	barrita.pushVertex(480,50);
	barrita.pushVertex(20,50);
	barrita.close( );
	barrita.fillPolygon( screen, 0x752C28 );

	for( int i=70; i<100; i++ ){
		barrita.matrix.displace(0, i );
		barrita.fillPolygon( screen, 0x752C28 );

	}
	screen.drawIcon( 26,502, 4);

	screen.print("-Es es una nota",30,700,0,0,0,3);
	screen.print("-Lavar el coche",30,620,0,0,0,3);
	screen.print("-Terminar Proy.",30,545,0,0,0,3);
}

void APP_TWITTER( ){
	Polygon2D PantallaPrincipal;
	PantallaPrincipal.clear( );
	PantallaPrincipal.create( );
	PantallaPrincipal.pushVertex( 20, 45 );
	PantallaPrincipal.pushVertex( 480, 45 );
	PantallaPrincipal.pushVertex( 480, 760 );
	PantallaPrincipal.pushVertex( 20, 760 );
	PantallaPrincipal.close( );
	PantallaPrincipal.fillPolygon( screen, 0xFFFFFF);	
	
	Polygon2D cuadro;
	cuadro.clear( );
	cuadro.create( );
	cuadro.pushVertex( 30, 0 );
	cuadro.pushVertex( 130, 0 );
	cuadro.pushVertex( 130, 100 );
	cuadro.pushVertex( 30, 100 );
	cuadro.close( );

	cuadro.matrix.displace( 20,580);
	cuadro.fillPolygon( screen, 0x3FADBD);

	Polygon2D circulito;
	circulito.createCircle(100,650,15);
	circulito.close( );
	circulito.fillPolygon(screen,0xFFFFFF);
	
	Polygon2D cuerpo;
	cuerpo.create( );
	cuerpo.pushVertex(70,600);
	cuerpo.pushVertex(130,600);
	cuerpo.pushVertex(100,650);
	cuerpo.close();
	cuerpo.fillPolygon( screen, 0xFFFFFF);

	screen.print("Casual hechando un tuist.",170,650,0,0,0,5);

	cuadro.matrix.displace(0,-150);
	cuadro.fillPolygon( screen, 0x3FADBD );
	circulito.matrix.displace(0,-150);
	circulito.fillPolygon( screen, 0xFFFFFF);
	cuerpo.matrix.displace(0,-150);
	cuerpo.fillPolygon( screen, 0xFFFFFF );
	screen.print("Terminando mi proyectin",170,490,0,0,0,5);	

	cuadro.matrix.displace(0,-150);
	cuadro.fillPolygon( screen, 0x3FADBD );
	circulito.matrix.displace(0,-150);
	circulito.fillPolygon( screen, 0xFFFFFF);
	cuerpo.matrix.displace(0,-150);
	cuerpo.fillPolygon( screen, 0xFFFFFF );
	screen.print("Viernes Examen :( ",170,350,0,0,0,5);	


	cuadro.matrix.displace(0,-150);
	cuadro.fillPolygon( screen, 0x3FADBD );
	circulito.matrix.displace(0,-150);
	circulito.fillPolygon( screen, 0xFFFFFF);
	cuerpo.matrix.displace(0,-150);
	cuerpo.fillPolygon( screen, 0xFFFFFF );
	screen.print("Estoy cansado :/ ",170,200,0,0,0,5);

}

void initNUM( ){
	index_ = 0;
	NUM[0]='\0';
}
void pushNUM( char *c ){
	if(index_>=11)
		return;
	NUM[index_++]=*c;
	NUM[index_]='\0';
}
char *getNUM( ){
	return NUM;
}
void POPNUM( ){
	if( index_ == 0 )
		return;
	index_--;
	NUM[index_]='\0';
}

void llamada_activa( ){
	switch(MOD/5){
		case 0:
			screen.print("Llamando .",30,620,255,255,255,9);
			break;
		case 1:
			screen.print("Llamando . .",30,620,255,255,255,9);
			break;
		case 2:
			screen.print("Llamando . . .",30,620,255,255,255,9);
			break;
	}
}

void APP_TELEFONO( ){
	MOD++;
	MOD%=15;

	Polygon2D PantallaPrincipal;
	PantallaPrincipal.clear( );
	PantallaPrincipal.create( );
	PantallaPrincipal.pushVertex( 20, 45 );
	PantallaPrincipal.pushVertex( 480, 45 );
	PantallaPrincipal.pushVertex( 480, 760 );
	PantallaPrincipal.pushVertex( 20, 760 );
	PantallaPrincipal.close( );
	PantallaPrincipal.fillPolygon( screen, 0x144A63);		

	Polygon2D barrita;
	barrita.create( );
	barrita.pushVertex(30,45);
	barrita.pushVertex(400,45);
	barrita.pushVertex(400,120);
	barrita.pushVertex(30,120);
	barrita.close( );
	barrita.matrix.displace(0, 590 );
	barrita.fillPolygon( screen, 0xFFFFFF );

	screen.print(getNUM(),30,705,0,0,0,7);

	Polygon2D boton_eliminar;
	boton_eliminar.create( );
	boton_eliminar.pushVertex(0,0);
	boton_eliminar.pushVertex(50,0);
	boton_eliminar.pushVertex(50,55);
	boton_eliminar.pushVertex(0,55);
	boton_eliminar.pushVertex(-20,27);
	boton_eliminar.close( );	
	boton_eliminar.matrix.displace(430,645);
	boton_eliminar.fillPolygon( screen, 0x8E8BB0 );

	Polygon2D boton;
	boton.create( );
	boton.pushVertex(0,0);
	boton.pushVertex(30,0);
	boton.pushVertex(30,20);
	boton.pushVertex(0,20);
	boton.close( );

	boton.matrix.displace(30,520);
	boton.matrix.scale(4,4);
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("1",65,610,255,255,255,8);

	boton.matrix.displace(40,0);
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("2",225,610,255,255,255,8);

	boton.matrix.displace(40,0);
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("3",385,610,255,255,255,8);

	boton.matrix.displace(-80,-30);	
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("4",65,490,255,255,255,8);

	boton.matrix.displace( 40, 0 );
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("5",225,490,255,255,255,8);

	boton.matrix.displace( 40, 0 );
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("6",385,490,255,255,255,8);

	boton.matrix.displace( -80, -30 );
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("7",65,370,255,255,255,8);

	boton.matrix.displace( 40, 0 );
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("8",225,370,255,255,255,8);

	boton.matrix.displace( 40, 0 );
	boton.fillPolygon( screen, 0x2AB4FF );	
	screen.print("9",385,370,255,255,255,8);

	boton.matrix.displace( -80, -30 );
	boton.fillPolygon( screen, 0x2AB4FF );	
	screen.print("*",65,250,255,255,255,8);

	boton.matrix.displace( 40, 0 );
	boton.fillPolygon( screen, 0x2AB4FF );	
	screen.print("0",225,250,255,255,255,8);

	boton.matrix.displace( 40, 0 );
	boton.fillPolygon( screen, 0x2AB4FF );
	screen.print("#",385,250,255,255,255,8);

	Polygon2D boton_llamar;
	boton_llamar.create( );
	boton_llamar.pushVertex(30,55);
	boton_llamar.pushVertex(470,55);
	boton_llamar.pushVertex(470,130);
	boton_llamar.pushVertex(30,130);
	boton_llamar.close( );
	boton_llamar.fillPolygon( screen, 0x2AFF9B);
	screen.print("Llamar",170,130,255,255,255,7);

	if( llamar  == 1 ){
		
		for( int i=20; i <480; i++ )
			for( int j=45; j<760; j++ )
				screen.putTransparencia( i, j );
		llamada_activa( );
		boton_llamar.fillPolygon( screen, 0xFF1F3A);
		screen.print("Cancelar",150,130,255,255,255,7);

	}
}
#endif