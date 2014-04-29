#ifndef _MATRIX_H_
#define _MATRIX_H_

#include <iostream>
#include <cmath>
#define _PI 3.1415926535

class Matrix{
	private:
		double m[3][3];
	public:
		Matrix( );
		void identity( );
		void print( );
		void println( );
		void setIndexOf( int , int, double );
		void setIndexOf( int , int, int    );
		double getIndexOf( int, int );
		void copy( double a[3][3] );
		void multiply( double a[3][3] );
		void displace( double, double );
		void rotate( double );
		void scale( double , double );
};

#endif
