#ifndef _POLYGON2D_H_
#define _POLYGON2D_H_

#include <iostream>
#include <vector>
#include <algorithm>
#include <cmath>
#include "Screen.cpp"
#include "Point.cpp"
#include "Matrix.cpp"
#define _PI 3.1415926535

class Polygon2D{
	private:
		std::vector< Point >vertex;
		bool flag;
	public:
		Matrix matrix;
		Polygon2D( );
		void clear( );
		void create( );
		void pushVertex( int x, int y );
		void pushVertex( double x, double y);
		void pushVertex( Point a );
		void close( );
		bool isClose( );
		int getSize( );
		Point getVertex( int );
		void drawPolygonOriginal( Screen, int );
		void drawPolygon( Screen screen, int COLOR );

		bool between( int, int, int );
		int interseccionX( Point a, Point b, int y);
		void __fillPolygon( std::vector< Point > , Screen, int  );
		void fillPolygon( Screen, int );
		void createCircle(int xc, int yc, int r );

};
#endif