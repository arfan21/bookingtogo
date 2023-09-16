package familyrepo

import (
	"context"
	"fmt"

	"github.com/arfan21/bookingtogo/family/familydomain"
	"github.com/jackc/pgx/v5/pgxpool"
)

type repository struct {
	db *pgxpool.Pool
}

func New(db *pgxpool.Pool) familydomain.Repository {
	return &repository{db: db}
}

func (r *repository) GetFamilyByCstID(ctx context.Context, cstID int) (res []familydomain.FamilyResponse, err error) {
	query := `
		SELECT
			fl_id,
			fl_name,
			fl_relation,
			fl_dob,
			cst_id
		FROM
			family_list
		WHERE
			cst_id = $1
	`

	rows, err := r.db.Query(ctx, query, cstID)
	if err != nil {
		err = fmt.Errorf("db: error when query get family by cst_id: %w", err)
		return
	}
	defer rows.Close()

	for rows.Next() {
		var family familydomain.FamilyResponse

		err = rows.Scan(
			&family.FLId,
			&family.FLName,
			&family.FLRelation,
			&family.FLDOB,
			&family.CstID,
		)

		if err != nil {
			err = fmt.Errorf("db: error when scan rows get family by cst_id: %w", err)
			return
		}

		res = append(res, family)

	}

	if rows.Err() != nil {
		err = fmt.Errorf("db: error when rows get family by cst_id: %w", err)
		return
	}

	return

}
